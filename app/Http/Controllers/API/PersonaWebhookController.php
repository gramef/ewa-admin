<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\KycSubmittedAdmin;
use App\Models\EProvider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Persona Identity Verification Webhook Controller
 * Receives webhook events from Persona when verification inquiries
 * are completed, approved, or failed.
 *
 * Webhook URL: POST /api/persona/webhook
 * Configure at: https://app.withpersona.com → Settings → Webhooks
 */
class PersonaWebhookController extends Controller
{
    /**
     * Handle incoming Persona webhook events.
     * No auth middleware — webhooks come from Persona servers.
     * Secured via HMAC signature verification.
     */
    public function handle(Request $request)
    {
        // Verify webhook signature
        if (!$this->verifySignature($request)) {
            Log::warning('Persona webhook: invalid signature');
            return response()->json(['error' => 'Invalid signature'], 403);
        }

        $payload = $request->all();
        $eventType = $payload['data']['attributes']['name'] ?? null;
        $inquiryId = $payload['data']['attributes']['payload']['data']['id'] ?? null;

        if (!$eventType || !$inquiryId) {
            Log::warning('Persona webhook: missing event type or inquiry ID', $payload);
            return response()->json(['received' => true]);
        }

        Log::info("Persona webhook received: {$eventType} for inquiry {$inquiryId}");

        $inquiryData = $payload['data']['attributes']['payload']['data']['attributes'] ?? [];
        $referenceId = $inquiryData['reference-id'] ?? null;

        // Find the provider by persona_inquiry_id
        $provider = EProvider::where('persona_inquiry_id', $inquiryId)->first();

        if (!$provider && $referenceId && $referenceId !== 'unknown') {
            $provider = EProvider::whereHas('users', fn($q) => $q->where('users.id', $referenceId))->first();
            if (!$provider && is_numeric($referenceId)) {
                $provider = EProvider::find($referenceId);
            }
            if ($provider) {
                $provider->update(['persona_inquiry_id' => $inquiryId]);
                Log::info("Persona webhook: linked inquiry {$inquiryId} to provider #{$provider->id} via reference ID {$referenceId}");
            }
        }

        if (!$provider) {
            Log::warning("Persona webhook: no provider found for inquiry {$inquiryId} (reference_id: " . ($referenceId ?? 'null') . ")");
            return response()->json(['received' => true]);
        }

        switch ($eventType) {
            case 'inquiry.completed':
                $this->handleCompleted($provider, $inquiryId, $inquiryData);
                break;

            case 'inquiry.approved':
                $this->handleApproved($provider, $inquiryId, $inquiryData);
                break;

            case 'inquiry.failed':
            case 'inquiry.declined':
                $this->handleFailed($provider, $inquiryId, $inquiryData);
                break;

            case 'inquiry.expired':
                $this->handleExpired($provider, $inquiryId);
                break;

            default:
                Log::info("Persona webhook: unhandled event type {$eventType}");
        }

        return response()->json(['received' => true]);
    }

    /**
     * Inquiry completed — user finished the verification flow.
     * Set status to 'pending' for admin review.
     */
    private function handleCompleted(EProvider $provider, string $inquiryId, array $data)
    {
        $fields = $this->extractFields($data);

        $provider->update([
            'kyc_status' => 'pending',
            'persona_status' => 'completed',
            'persona_fields' => json_encode($fields),
            'kyc_submitted_at' => now(),
            'kyc_reviewed_at' => null,
            'kyc_rejection_reason' => null,
        ]);

        Log::info("Persona inquiry {$inquiryId} completed for provider #{$provider->id}");

        // Notify all admin users
        $this->notifyAdmins($provider);
    }

    /**
     * Inquiry approved by Persona's automated checks.
     * Still set to 'pending' — admin has final approval.
     */
    private function handleApproved(EProvider $provider, string $inquiryId, array $data)
    {
        $fields = $this->extractFields($data);

        $wasNotSubmitted = $provider->kyc_status === 'not_submitted';

        $provider->update([
            'persona_status' => 'approved',
            'persona_fields' => json_encode($fields),
            // Keep kyc_status as 'pending' — admin makes final call
            'kyc_status' => $wasNotSubmitted ? 'pending' : $provider->kyc_status,
            'kyc_submitted_at' => $provider->kyc_submitted_at ?? now(),
        ]);

        Log::info("Persona inquiry {$inquiryId} auto-approved for provider #{$provider->id}");

        // Notify admins if this is the first time reaching pending
        if ($wasNotSubmitted) {
            $this->notifyAdmins($provider);
        }
    }

    /**
     * Inquiry failed or declined by Persona.
     */
    private function handleFailed(EProvider $provider, string $inquiryId, array $data)
    {
        $provider->update([
            'persona_status' => 'failed',
            'persona_fields' => json_encode($this->extractFields($data)),
            'kyc_status' => 'rejected',
            'kyc_rejection_reason' => 'Identity verification failed. Please try again with a valid government ID.',
            'kyc_reviewed_at' => now(),
        ]);

        Log::info("Persona inquiry {$inquiryId} failed for provider #{$provider->id}");
    }

    /**
     * Inquiry expired — user didn't complete in time.
     */
    private function handleExpired(EProvider $provider, string $inquiryId)
    {
        $provider->update([
            'persona_status' => 'expired',
            'kyc_status' => 'not_submitted',
        ]);

        Log::info("Persona inquiry {$inquiryId} expired for provider #{$provider->id}");
    }

    /**
     * Notify all admin users about a new KYC submission.
     */
    private function notifyAdmins(EProvider $provider)
    {
        try {
            $vendorUser = $provider->users()->first();
            $vendorName = $vendorUser->name ?? (is_array($provider->name) ? ($provider->name['en'] ?? 'Vendor') : ($provider->name ?? 'Vendor'));
            $vendorEmail = $vendorUser->email ?? 'N/A';

            $admins = User::role('admin')->get();
            foreach ($admins as $admin) {
                if ($admin->email) {
                    Mail::to($admin->email)->send(new KycSubmittedAdmin(
                        $vendorName,
                        $vendorEmail,
                        $provider->id,
                        'persona'
                    ));
                }
            }

            Log::info("KYC admin notifications sent for provider #{$provider->id} to " . $admins->count() . " admin(s)");
        } catch (\Exception $e) {
            Log::error("Failed to send KYC admin notification: " . $e->getMessage());
        }
    }

    /**
     * Extract useful fields from Persona inquiry data.
     */
    private function extractFields(array $data): array
    {
        return [
            'status' => $data['status'] ?? null,
            'reference_id' => $data['reference-id'] ?? null,
            'name_first' => $data['name-first'] ?? null,
            'name_last' => $data['name-last'] ?? null,
            'birthdate' => $data['birthdate'] ?? null,
            'document_type' => $data['fields']['government-id-number']['value'] ?? null,
            'completed_at' => $data['completed-at'] ?? null,
        ];
    }

    /**
     * Verify Persona webhook signature (HMAC-SHA256).
     */
    private function verifySignature(Request $request): bool
    {
        $secret = config('services.persona.webhook_secret');

        // Skip verification if no secret configured (dev/sandbox)
        if (empty($secret)) {
            Log::debug('Persona webhook: no secret configured, skipping signature check');
            return true;
        }

        $signature = $request->header('Persona-Signature');
        if (!$signature) {
            return false;
        }

        // Persona sends: t=timestamp,v1=signature
        $parts = [];
        foreach (explode(',', $signature) as $part) {
            [$key, $value] = explode('=', $part, 2);
            $parts[$key] = $value;
        }

        if (!isset($parts['t']) || !isset($parts['v1'])) {
            return false;
        }

        $payload = $parts['t'] . '.' . $request->getContent();
        $expected = hash_hmac('sha256', $payload, $secret);

        return hash_equals($expected, $parts['v1']);
    }
}
