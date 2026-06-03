<?php
/*
 * File name: EProviderSubscriptionWebController.php
 * Author: EWA Platform
 */

namespace Modules\Subscription\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Flash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Modules\Subscription\DataTables\EProviderSubscriptionDataTable;
use Modules\Subscription\Models\EProviderSubscription;

/**
 * Class EProviderSubscriptionWebController
 * Web (Blade/DataTables) controller for viewing Provider Subscriptions in the admin panel.
 *
 * @package Modules\Subscription\Http\Controllers\Admin
 */
class EProviderSubscriptionWebController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of provider subscriptions.
     *
     * @param EProviderSubscriptionDataTable $dataTable
     * @return mixed
     */
    public function index(EProviderSubscriptionDataTable $dataTable)
    {
        return $dataTable->render('subscription::e_provider_subscriptions.index');
    }

    /**
     * Remove / cancel the specified provider subscription.
     *
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(int $id)
    {
        $subscription = EProviderSubscription::find($id);

        if (empty($subscription)) {
            Flash::error(__('lang.not_found', ['operator' => __('subscription::lang.e_provider_subscription')]));
            return redirect(route('eProviderSubscriptions.index'));
        }

        try {
            $subscription->update([
                'active' => false,
                'notes' => ($subscription->notes ? $subscription->notes . ' | ' : '') . 'Cancelled by admin on ' . now()->toDateTimeString(),
            ]);
            Flash::success(__('lang.deleted_successfully', ['operator' => __('subscription::lang.e_provider_subscription')]));
        } catch (Exception $e) {
            Flash::error($e->getMessage());
        }

        return redirect(route('eProviderSubscriptions.index'));
    }

    /**
     * Extend a provider subscription by 30 days.
     *
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function extend(int $id)
    {
        $subscription = EProviderSubscription::find($id);

        if (empty($subscription)) {
            Flash::error(__('lang.not_found', ['operator' => __('subscription::lang.e_provider_subscription')]));
            return redirect(route('eProviderSubscriptions.index'));
        }

        try {
            $currentEnd = $subscription->ends_at ? \Carbon\Carbon::parse($subscription->ends_at) : now();
            // If already expired, extend from today; otherwise extend from current end date
            $baseDate = $currentEnd->isPast() ? now() : $currentEnd;

            $subscription->update([
                'ends_at' => $baseDate->addDays(30),
                'active' => true,
                'notes' => ($subscription->notes ? $subscription->notes . ' | ' : '') . 'Extended 30 days by admin on ' . now()->toDateTimeString(),
            ]);
            Flash::success('Subscription extended by 30 days successfully.');
        } catch (Exception $e) {
            Flash::error($e->getMessage());
        }

        return redirect(route('eProviderSubscriptions.index'));
    }
}
