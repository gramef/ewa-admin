<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\VendorApplicationReceived;
use App\Models\EProvider;
use App\Services\GoogleDriveKycService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

/**
 * KYC Document Upload Controller
 * Handles vendor identity verification document uploads.
 * Documents are stored in Google Drive for GDPR compliance.
 * Falls back to local storage if Google Drive is not configured.
 */
class KycController extends Controller
{
    private GoogleDriveKycService $driveService;

    public function __construct(GoogleDriveKycService $driveService)
    {
        $this->driveService = $driveService;
    }

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
            $idPath = null;
            $rtwPath = null;
            $idDriveFileId = null;
            $rtwDriveFileId = null;

            // Try Google Drive first, fall back to local
            if ($this->driveService->isConfigured()) {
                $vendorName = $provider->name ?? 'Vendor';

                $idResult = $this->driveService->uploadDocument(
                    $request->file('id_document'),
                    $provider->id,
                    $vendorName,
                    'id_document'
                );
                $idDriveFileId = $idResult['file_id'];
                $idPath = 'gdrive:' . $idDriveFileId;

                $rtwResult = $this->driveService->uploadDocument(
                    $request->file('rtw_document'),
                    $provider->id,
                    $vendorName,
                    'rtw_document'
                );
                $rtwDriveFileId = $rtwResult['file_id'];
                $rtwPath = 'gdrive:' . $rtwDriveFileId;

                Log::info("KYC documents uploaded to Google Drive for provider #{$provider->id}");
            } else {
                // Fallback: store locally (legacy behaviour)
                $idPath = $request->file('id_document')->store('kyc/' . $provider->id, 'local');
                $rtwPath = $request->file('rtw_document')->store('kyc/' . $provider->id, 'local');

                Log::warning("Google Drive not configured — KYC documents stored locally for provider #{$provider->id}");
            }

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

            // Send Application Received email (SOP Template 1)
            if ($user->email) {
                try {
                    $vendorName = $user->name ?? 'there';
                    Mail::to($user->email)->send(new VendorApplicationReceived($vendorName));
                    Log::info("Application received email sent to {$user->email}");
                } catch (\Exception $mailErr) {
                    Log::error("Failed to send application received email: " . $mailErr->getMessage());
                }
            }

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
