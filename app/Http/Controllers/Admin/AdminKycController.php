<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Admin KYC Review Controller
 * Review, approve, and reject vendor KYC documents
 */
class AdminKycController extends Controller
{
    /**
     * KYC dashboard — list all submissions grouped by status.
     */
    public function index()
    {
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

        return view('dashboard.kyc_review', compact('pending', 'verified', 'rejected'));
    }

    /**
     * Show a specific vendor's KYC documents.
     */
    public function show($id)
    {
        $provider = EProvider::with('user')->findOrFail($id);
        return view('dashboard.kyc_detail', compact('provider'));
    }

    /**
     * Download/view a KYC document.
     */
    public function document($id, $type)
    {
        $provider = EProvider::findOrFail($id);
        $field = $type === 'id' ? 'kyc_id_document' : 'kyc_rtw_document';
        $path = $provider->$field;

        if (!$path || !Storage::disk('local')->exists($path)) {
            abort(404, 'Document not found');
        }

        return Storage::disk('local')->download($path);
    }

    /**
     * Approve a vendor's KYC.
     */
    public function approve($id)
    {
        $provider = EProvider::findOrFail($id);
        $provider->update([
            'kyc_status' => 'verified',
            'kyc_reviewed_at' => now(),
            'kyc_rejection_reason' => null,
        ]);

        Log::info("KYC APPROVED for provider #{$id} by admin #" . auth()->id());

        return redirect()->route('admin.kyc.index')
            ->with('success', "KYC approved for {$provider->name}");
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

        return redirect()->route('admin.kyc.index')
            ->with('warning', "KYC rejected for {$provider->name}");
    }
}
