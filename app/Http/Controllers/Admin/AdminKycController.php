<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\VendorApproved;
use App\Mail\VendorDeclined;
use App\Mail\VendorDocumentsRequired;
use App\Models\EProvider;
use App\Services\GoogleDriveKycService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

/**
 * Admin KYC Review Controller
 * Review, approve, and reject vendor KYC documents.
 * 
 * GDPR Compliance:
 * - Documents are viewed in-browser only (no download to admin PC)
 * - All document access is audit-logged
 * - Access restricted to users with admin.kyc.* permissions
 */
class AdminKycController extends Controller
{
    /**
     * Get Google Drive service if available (lazy, optional).
     */
    private function getDriveService()
    {
        try {
            if (class_exists(\Google_Client::class)) {
                $service = app(\App\Services\GoogleDriveKycService::class);
                return $service->isConfigured() ? $service : null;
            }
        } catch (\Exception $e) {
            \Log::debug('Google Drive KYC service not available: ' . $e->getMessage());
        }
        return null;
    }

    /**
     * Check if KYC columns exist in the database
     */
    private function kycColumnsExist(): bool
    {
        try {
            return Schema::hasColumn('e_providers', 'kyc_status');
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * KYC dashboard — list all submissions grouped by status.
     */
    public function index()
    {
        if (!$this->kycColumnsExist()) {
            $pending = collect([]);
            $verified = collect([]);
            $rejected = collect([]);
            $needsMigration = true;
            return view('dashboard.kyc_review', compact('pending', 'verified', 'rejected', 'needsMigration'));
        }

        try {
            $pending = EProvider::where('kyc_status', 'pending')
                ->with('user')
                ->orderBy('kyc_submitted_at', 'desc')
                ->get();

            $verified = EProvider::where('kyc_status', 'verified')
                ->with('user')
                ->orderBy('kyc_reviewed_at', 'desc')
                ->limit(50)
                ->get();

            $rejected = EProvider::where('kyc_status', 'rejected')
                ->with('user')
                ->orderBy('kyc_reviewed_at', 'desc')
                ->limit(50)
                ->get();
        } catch (\Exception $e) {
            $pending = collect([]);
            $verified = collect([]);
            $rejected = collect([]);
        }

        $needsMigration = false;
        return view('dashboard.kyc_review', compact('pending', 'verified', 'rejected', 'needsMigration'));
    }

    /**
     * Show a specific vendor's KYC documents.
     */
    public function show($id)
    {
        $provider = EProvider::with('user')->findOrFail($id);

        // Audit log: who viewed this KYC
        Log::channel('single')->info('KYC_ACCESS', [
            'action' => 'view_detail',
            'provider_id' => $id,
            'provider_name' => $provider->name,
            'admin_id' => auth()->id(),
            'admin_email' => auth()->user()->email ?? 'unknown',
            'ip' => request()->ip(),
            'timestamp' => now()->toIso8601String(),
        ]);

        return view('dashboard.kyc_detail', compact('provider'));
    }

    /**
     * View a KYC document securely (no download).
     * For Google Drive docs: renders an embedded viewer.
     * For local docs: streams inline to the browser.
     */
    public function document($id, $type)
    {
        $provider = EProvider::findOrFail($id);
        $field = $type === 'id' ? 'kyc_id_document' : 'kyc_rtw_document';
        $path = $provider->$field;

        if (!$path) {
            abort(404, 'Document not found');
        }

        // Audit log: who accessed this document
        Log::channel('single')->info('KYC_DOCUMENT_ACCESS', [
            'action' => 'view_document',
            'document_type' => $type,
            'provider_id' => $id,
            'provider_name' => $provider->name,
            'admin_id' => auth()->id(),
            'admin_email' => auth()->user()->email ?? 'unknown',
            'ip' => request()->ip(),
            'timestamp' => now()->toIso8601String(),
        ]);

        // Google Drive document
        if (str_starts_with($path, 'gdrive:')) {
            $fileId = str_replace('gdrive:', '', $path);
            $driveService = $this->getDriveService();

            if (!$driveService) {
                abort(500, 'Google Drive service not available');
            }

            $viewUrl = $driveService->getViewUrl($fileId);

            if ($viewUrl) {
                // Return an HTML page with embedded Google Drive viewer
                return response()->view('dashboard.kyc_document_viewer', [
                    'viewUrl' => $viewUrl,
                    'docType' => $type === 'id' ? 'ID Document' : 'Right to Work Document',
                    'providerName' => $provider->name,
                ]);
            }

            // Fallback: stream from Google Drive
            $doc = $driveService->getDocumentContent($fileId);
            if ($doc) {
                return response($doc['content'])
                    ->header('Content-Type', $doc['mimeType'])
                    ->header('Content-Disposition', 'inline; filename="' . $doc['name'] . '"')
                    ->header('X-Content-Type-Options', 'nosniff')
                    ->header('Cache-Control', 'no-store, no-cache, must-revalidate');
            }

            abort(404, 'Document not found in Google Drive');
        }

        // Local document (legacy) — stream inline, NOT download
        if (!Storage::disk('local')->exists($path)) {
            abort(404, 'Document not found');
        }

        $mimeType = Storage::disk('local')->mimeType($path);
        $content = Storage::disk('local')->get($path);

        return response($content)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'inline; filename="kyc_' . $type . '_' . $id . '"')
            ->header('X-Content-Type-Options', 'nosniff')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate');
    }

    /**
     * Approve a vendor's KYC.
     */
    public function approve($id)
    {
        $provider = EProvider::findOrFail($id);
        $provider->update([
            'accepted' => true,
            'kyc_status' => 'verified',
            'kyc_reviewed_at' => now(),
            'kyc_rejection_reason' => null,
        ]);

        Log::info("KYC APPROVED for provider #{$id} by admin #" . auth()->id());

        // Audit log
        Log::channel('single')->info('KYC_DECISION', [
            'action' => 'approve',
            'provider_id' => $id,
            'admin_id' => auth()->id(),
            'admin_email' => auth()->user()->email ?? 'unknown',
            'timestamp' => now()->toIso8601String(),
        ]);

        // Send Welcome email (SOP Template 3 — Application Approved)
        $user = $provider->users()->first();
        if ($user && $user->email) {
            $vendorName = $user->name ?? 'there';
            $vendorPwaUrl = config('app.vendor_pwa_url', 'https://ewa-vendor-pwa.vercel.app');
            try {
                Mail::to($user->email)->send(new VendorApproved($vendorName, $vendorPwaUrl));
                Log::info("Welcome email sent to {$user->email} for provider #{$id}");
            } catch (\Exception $e) {
                Log::error("Failed to send welcome email to {$user->email}: " . $e->getMessage());
            }
        }

        return redirect()->route('admin.kyc.index')
            ->with('success', "KYC approved for {$provider->name}. Welcome email sent.");
    }

    /**
     * Reject a vendor's KYC with reason.
     */
    public function reject(Request $request, $id)
    {
        $request->validate(['reason' => 'required|string|max:500']);

        $provider = EProvider::findOrFail($id);
        $provider->update([
            'kyc_status' => 'rejected',
            'kyc_reviewed_at' => now(),
            'kyc_rejection_reason' => $request->reason,
        ]);

        Log::info("KYC REJECTED for provider #{$id}: {$request->reason}");

        // Audit log
        Log::channel('single')->info('KYC_DECISION', [
            'action' => 'reject',
            'provider_id' => $id,
            'reason' => $request->reason,
            'admin_id' => auth()->id(),
            'admin_email' => auth()->user()->email ?? 'unknown',
            'timestamp' => now()->toIso8601String(),
        ]);

        // Send Declined email (SOP Template 4 — Application Declined)
        $user = $provider->users()->first();
        if ($user && $user->email) {
            $vendorName = $user->name ?? 'there';
            try {
                Mail::to($user->email)->send(new VendorDeclined($vendorName, $request->reason));
                Log::info("Decline email sent to {$user->email} for provider #{$id}");
            } catch (\Exception $e) {
                Log::error("Failed to send decline email to {$user->email}: " . $e->getMessage());
            }
        }

        return redirect()->route('admin.kyc.index')
            ->with('warning', "KYC rejected for {$provider->name}. Decline email sent.");
    }

    /**
     * Request additional documents from a vendor (SOP Template 2).
     */
    public function requestDocuments(Request $request, $id)
    {
        $request->validate(['notes' => 'nullable|string|max:1000']);

        $provider = EProvider::findOrFail($id);
        $user = $provider->users()->first();

        if (!$user || !$user->email) {
            return redirect()->back()->with('error', 'No email found for this vendor.');
        }

        $vendorName = $user->name ?? 'there';
        $vendorPwaUrl = config('app.vendor_pwa_url', 'https://ewa-vendor-pwa.vercel.app');
        $notes = $request->input('notes', '');

        // Audit log
        Log::channel('single')->info('KYC_DECISION', [
            'action' => 'request_documents',
            'provider_id' => $id,
            'notes' => $notes,
            'admin_id' => auth()->id(),
            'admin_email' => auth()->user()->email ?? 'unknown',
            'timestamp' => now()->toIso8601String(),
        ]);

        try {
            Mail::to($user->email)->send(new VendorDocumentsRequired($vendorName, $vendorPwaUrl, $notes));
            Log::info("Documents required email sent to {$user->email} for provider #{$id}");

            return redirect()->back()
                ->with('success', "Document request email sent to {$user->email}");
        } catch (\Exception $e) {
            Log::error("Failed to send documents required email: " . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to send email: ' . $e->getMessage());
        }
    }
}
