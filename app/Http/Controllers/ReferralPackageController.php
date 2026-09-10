<?php

namespace App\Http\Controllers;

use App\Models\ReferralPackage;
use App\Models\UserReferral;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class ReferralPackageController extends Controller
{
    public function index(Request $request)
    {
        $packages = ReferralPackage::withCount('referrals')->latest()->paginate(15);
        $recentReferrals = UserReferral::with(['referrer', 'referee', 'package', 'qualifyingBooking'])
            ->latest()
            ->paginate(20, ['*'], 'referrals_page');

        $stats = [
            'total_packages' => ReferralPackage::count(),
            'active_packages' => ReferralPackage::where('enabled', true)->count(),
            'total_referrals' => UserReferral::count(),
            'rewarded_referrals' => UserReferral::where('status', 'rewarded')->count(),
            'pending_referrals' => UserReferral::where('status', 'pending')->count(),
        ];

        return view('referral_packages.index', compact('packages', 'recentReferrals', 'stats'));
    }

    public function create()
    {
        return view('referral_packages.create');
    }

    public function store(Request $request)
    {
        $input = $request->validate(ReferralPackage::$rules);
        $input['enabled'] = $request->boolean('enabled');

        ReferralPackage::create($input);

        Flash::success(__('lang.saved_successfully', ['operator' => 'Referral Package']));
        return redirect(route('referralPackages.index'));
    }

    public function edit($id)
    {
        $referralPackage = ReferralPackage::findOrFail($id);
        return view('referral_packages.edit', compact('referralPackage'));
    }

    public function update($id, Request $request)
    {
        $referralPackage = ReferralPackage::findOrFail($id);

        $rules = ReferralPackage::$rules;
        $input = $request->validate($rules);
        $input['enabled'] = $request->boolean('enabled');

        $referralPackage->update($input);

        Flash::success(__('lang.updated_successfully', ['operator' => 'Referral Package']));
        return redirect(route('referralPackages.index'));
    }

    public function destroy($id)
    {
        $referralPackage = ReferralPackage::findOrFail($id);
        $referralPackage->delete();

        Flash::success(__('lang.deleted_successfully', ['operator' => 'Referral Package']));
        return redirect(route('referralPackages.index'));
    }

    public function toggle($id)
    {
        $referralPackage = ReferralPackage::findOrFail($id);
        $referralPackage->enabled = !$referralPackage->enabled;
        $referralPackage->save();

        Flash::success('Referral package status updated.');
        return redirect()->back();
    }
}
