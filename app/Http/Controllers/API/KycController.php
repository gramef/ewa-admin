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
    /**
     * Get Google Drive service if available (lazy, optional).
     * Returns null if google/apiclient is not installed or not configured.
     */
    private function getDriveService()
    {
        try {
            if (class_exists(\Google_Client::class)) {
                $service = app(\App\Services\GoogleDriveKycService::class);
                return $service->isConfigured() ? $service : null;
            }
        } catch (\Exception $e) {
            Log::debug('Google Drive KYC service not available: ' . $e->getMessage());
        }
        return null;
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
            'persona_inquiry_id' => $provider->persona_inquiry_id,
            'persona_status' => $provider->persona_status,
            'kyc_rtw_share_code' => $provider->kyc_rtw_share_code,
            'kyc_rtw_dob' => $provider->kyc_rtw_dob,
            'kyc_rtw_method' => $provider->kyc_rtw_method,
        ], 'KYC status retrieved');
    }

    /**
     * Save optional UK Right to Work share code & DOB.
     * POST /api/kyc/rtw
     */
    public function saveRtw(Request $request)
    {
        $user = Auth::user();
        if (!$user) return $this->sendError('Unauthorized', 401);

        $provider = EProvider::whereHas('users', fn($q) => $q->where('users.id', $user->id))->first();
        if (!$provider) return $this->sendError('No provider profile found');

        $request->validate([
            'rtw_share_code' => 'required|string|size:9|alpha_num',
            'rtw_dob' => 'required|date|before:today',
        ]);

        $provider->update([
            'kyc_rtw_share_code' => strtoupper(trim($request->rtw_share_code)),
            'kyc_rtw_dob' => $request->rtw_dob,
            'kyc_rtw_method' => 'share_code',
        ]);

        Log::info("Right to Work share code updated for provider #{$provider->id}");

        return $this->sendResponse([
            'kyc_rtw_share_code' => $provider->kyc_rtw_share_code,
            'kyc_rtw_dob' => $provider->kyc_rtw_dob,
        ], 'Right to work details saved');
    }

    /**
     * Register a Persona inquiry ID for this vendor.
     * Called by the vendor PWA after opening the Persona widget.
     * POST /api/kyc/persona-start
     */
    public function personaStart(Request $request)
    {
        $user = Auth::user();
        if (!$user) return $this->sendError('Unauthorized', 401);

        $provider = EProvider::whereHas('users', fn($q) => $q->where('users.id', $user->id))->first();
        if (!$provider) return $this->sendError('No provider profile found');

        $request->validate([
            'inquiry_id' => 'required|string|max:255',
        ]);

        $provider->update([
            'persona_inquiry_id' => $request->inquiry_id,
            'persona_status' => 'started',
            'kyc_status' => $provider->kyc_status === 'not_submitted' || $provider->kyc_status === 'rejected'
                ? 'verifying'
                : $provider->kyc_status,
        ]);

        Log::info("Persona inquiry {$request->inquiry_id} started for provider #{$provider->id}");

        return $this->sendResponse(['status' => 'registered'], 'Persona inquiry registered');
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

        // Determine RTW method: share_code or document
        $rtwMethod = $request->input('rtw_method', 'document');

        // Base validation
        $rules = [
            'id_type' => 'required|in:passport,driving_licence,national_id,biometric_card',
            'id_document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'rtw_method' => 'required|in:share_code,document',
        ];

        // Conditional RTW validation
        if ($rtwMethod === 'share_code') {
            $rules['rtw_share_code'] = 'required|string|size:9|alpha_num';
            $rules['rtw_dob'] = 'required|date|before:today';
        } else {
            $rules['rtw_document'] = 'required|file|mimes:jpg,jpeg,png,pdf|max:10240';
        }

        $request->validate($rules);

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
            $driveService = $this->getDriveService();

            // Upload ID document to Google Drive (or local fallback)
            if ($driveService) {
                $vendorName = $provider->name ?? 'Vendor';

                $idResult = $driveService->uploadDocument(
                    $request->file('id_document'),
                    $provider->id,
                    $vendorName,
                    'id_document'
                );
                $idPath = 'gdrive:' . $idResult['file_id'];

                Log::info("KYC ID document uploaded to Google Drive for provider #{$provider->id}");
            } else {
                $idPath = $request->file('id_document')->store('kyc/' . $provider->id, 'local');
                Log::info("KYC ID document stored locally for provider #{$provider->id}");
            }

            // Handle RTW based on method
            $updateData = [
                'kyc_status' => 'pending',
                'kyc_id_type' => $request->id_type,
                'kyc_id_document' => $idPath,
                'kyc_rtw_method' => $rtwMethod,
                'kyc_rejection_reason' => null,
                'kyc_submitted_at' => now(),
                'kyc_reviewed_at' => null,
            ];

            if ($rtwMethod === 'share_code') {
                // UK GOV Share Code — no document storage needed
                $updateData['kyc_rtw_share_code'] = strtoupper($request->rtw_share_code);
                $updateData['kyc_rtw_dob'] = $request->rtw_dob;
                $updateData['kyc_rtw_document'] = null;

                Log::info("KYC RTW via UK Share Code for provider #{$provider->id}");
            } else {
                // Traditional document upload
                if ($driveService) {
                    $vendorName = $provider->name ?? 'Vendor';
                    $rtwResult = $driveService->uploadDocument(
                        $request->file('rtw_document'),
                        $provider->id,
                        $vendorName,
                        'rtw_document'
                    );
                    $rtwPath = 'gdrive:' . $rtwResult['file_id'];
                } else {
                    $rtwPath = $request->file('rtw_document')->store('kyc/' . $provider->id, 'local');
                }
                $updateData['kyc_rtw_document'] = $rtwPath;
                $updateData['kyc_rtw_share_code'] = null;
                $updateData['kyc_rtw_dob'] = null;
            }

            $provider->update($updateData);

            Log::info("KYC submitted for provider #{$provider->id} by user #{$user->id} (RTW method: {$rtwMethod})");

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
                'message' => 'Submitted successfully. Review takes 24-48 hours.',
            ], 'KYC submitted');

        } catch (\Exception $e) {
            Log::error('KYC submission failed: ' . $e->getMessage());
            return $this->sendError('Failed to submit. Please try again.');
        }
    }
}
