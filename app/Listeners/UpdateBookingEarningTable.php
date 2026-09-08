<?php
/*
 * File name: UpdateBookingEarningTable.php
 * Last modified: 2021.06.10 at 20:37:20
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

namespace App\Listeners;

use App\Criteria\Bookings\BookingsOfProviderCriteria;
use App\Criteria\Bookings\PaidBookingsCriteria;
use App\Repositories\BookingRepository;
use App\Repositories\EarningRepository;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class UpdateBookingEarningTable
 * @package App\Listeners
 */
class UpdateBookingEarningTable
{
    /**
     * @var EarningRepository
     */
    private $earningRepository;

    /**
     * @var BookingRepository
     */
    private $bookingRepository;

    /**
     * Create the event listener.
     *
     * @param EarningRepository $earningRepository
     * @param BookingRepository $bookingRepository
     */
    public function __construct(EarningRepository $earningRepository, BookingRepository $bookingRepository)
    {
        $this->earningRepository = $earningRepository;
        $this->bookingRepository = $bookingRepository;
    }

    /**
     * Handle the event.
     * oldBooking
     * updatedBooking
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        try {
            $this->bookingRepository->pushCriteria(new BookingsOfProviderCriteria($event->eProvider->id));
            $this->bookingRepository->pushCriteria(new PaidBookingsCriteria());
            $bookings = $this->bookingRepository->all();
            $bookingsCount = $bookings->count();

            $bookingsTotals = $bookings->map(function ($booking) {
                return $booking->getTotal();
            })->toArray();

            $bookingsTaxes = $bookings->map(function ($booking) {
                return $booking->getTaxesValue();
            })->toArray();

            $total = array_reduce($bookingsTotals, function ($total1, $total2) {
                return $total1 + $total2;
            }, 0);

            $tax = array_reduce($bookingsTaxes, function ($tax1, $tax2) {
                return $tax1 + $tax2;
            }, 0);
            $payout = (float) DB::table('e_provider_payouts')
                ->where('e_provider_id', $event->eProvider->id)
                ->where('paid', 1)
                ->sum('amount');

            // Determine commission percentage (0% platform commission under subscription model)
            $platformCommissionPercent = 0.0;
            if (class_exists('\Nwidart\Modules\Facades\Module') && \Nwidart\Modules\Facades\Module::isActivated('Subscription')) {
                $activeSub = \Modules\Subscription\Models\EProviderSubscription::where('e_provider_id', $event->eProvider->id)
                    ->valid()
                    ->with('subscriptionPackage')
                    ->first();

                if ($activeSub && $activeSub->subscriptionPackage) {
                    $platformCommissionPercent = (float) ($activeSub->subscriptionPackage->commission_percentage ?? 0.0);
                }
            } else if (!empty($event->eProvider->eProviderType)) {
                // Fallback: If eProviderType has commission defined (e.g. 100 = 100% to provider, 0% to platform)
                $providerShare = (float) $event->eProvider->eProviderType->commission;
                $platformCommissionPercent = max(0.0, 100.0 - $providerShare);
            }

            $netBookingTotal = max(0.0, $total - $tax);
            $adminEarning = $netBookingTotal * ($platformCommissionPercent / 100.0);
            $grossProviderEarning = $netBookingTotal - $adminEarning;

            $this->earningRepository->updateOrCreate(['e_provider_id' => $event->eProvider->id], [
                    'total_bookings' => $bookingsCount,
                    'total_earning' => $netBookingTotal,
                    'taxes' => $tax,
                    'admin_earning' => $adminEarning,
                    'e_provider_earning' => $grossProviderEarning - $payout,
                    'payout' => $payout,
                ]
            );
        } catch (ValidatorException | RepositoryException $e) {
        } finally {
            $this->bookingRepository->resetCriteria();
        }
    }
}
