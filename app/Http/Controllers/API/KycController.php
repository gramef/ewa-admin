<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\EProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

/**
 * KYC Document Upload Controller
 * Handles vendor identity verification document uploads
 */
class KycController extends Controller
{
    /**
     * Get current KYC status for the authenticated vendor's provider.
     * GET /api/kyc/status
     */
    public function status(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return $this->sendError('Unauthorized', 401);
        }

        $provider = EProvider::whereHas('users', fn($q) => $q->where('users.id', $user->id))->first();
        if (!$provider) {
            return $this->sendResponse([
                'kyc_status' => 'not_submitted',
            ], 'No provider found');
        }

        return $this->sendResponse([
            'kyc_status' => $provider->kyc_status ?? 'not_submitted',
            'kyc_id_type' => $provider->kyc_id_type,
            'kyc_submitted_at' => $provider->kyc_submitted_at,
            'kyc_reviewed_at' => $provider->kyc_reviewed_at,
            'kyc_rejection_reason' => $provider->kyc_rejection_reason,
        ], 'KYC status retrieved');
    }

    /**
     * Submit KYC documents.
     * POST /api/kyc/submit
     */
    public function submit(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return $this->sendError('Unauthorized', 401);
        }

        $provider = EProvider::whereHas('users', fn($q) => $q->where('users.id', $user->id))->first();
        if (!$provider) {
            return $this->sendError('No provider profile found');
        }

        // Validate
        $request->validate([
            'id_type' => 'required|in:passport,driving_licence,national_id,biometric_card',
            'id_document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'rtw_document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        // Check if already pending or verified
        if ($provider->kyc_status === 'pending') {
            return $this->sendError('Documents already submitted and under review');
        }
        if ($provider->kyc_status === 'verified') {
            return $this->sendError('Already verified');
        }

        try {
            // Store documents securely (not publicly accessible)
            $idPath = $request->file('id_document')->store('kyc/' . $provider->id, 'local');
            $rtwPath = $request->file('rtw_document')->store('kyc/' . $provider->id, 'local');

            // Update provider record
            $provider->update([
                'kyc_status' => 'pending',
                'kyc_id_type' => $request->id_type,
                'kyc_id_document' => $idPath,
                'kyc_rtw_document' => $rtwPath,
                'kyc_rejection_reason' => null,
                'kyc_submitted_at' => now(),
                'kyc_reviewed_at' => null,
            ]);

            Log::info("KYC documents submitted for provider #{$provider->id} by user #{$user->id}");

            return $this->sendResponse([
                'kyc_status' => 'pending',
                'message' => 'Documents submitted successfully. Review takes 24-48 hours.',
            ], 'KYC documents submitted');

        } catch (\Exception $e) {
            Log::error('KYC submission failed: ' . $e->getMessage());
            return $this->sendError('Failed to upload documents. Please try again.');
        }
    }
}
