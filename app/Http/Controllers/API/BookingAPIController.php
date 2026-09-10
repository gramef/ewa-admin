<?php
/*
 * File name: BookingAPIController.php
 * Last modified: 2021.11.01 at 22:25:44
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

namespace App\Http\Controllers\API;


use App\Criteria\Bookings\BookingsOfUserCriteria;
use App\Events\BookingChangedEvent;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Notifications\NewBooking;
use App\Notifications\StatusChangedBooking;
use App\Notifications\BookingCancelledNotification;
use App\Services\CancellationService;
use App\Repositories\AddressRepository;
use App\Repositories\BookingRepository;
use App\Repositories\BookingStatusRepository;
use App\Repositories\CouponRepository;
use App\Repositories\CustomFieldRepository;
use App\Repositories\EProviderLocationRepository;
use App\Repositories\EProviderRepository;
use App\Repositories\EServiceRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\OptionRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\PaymentStatusRepository;
use App\Repositories\TaxRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Support\Facades\Log;

/**
 * Class BookingController
 * @package App\Http\Controllers\API
 */
class BookingAPIController extends Controller
{
    /** @var  BookingRepository */
    private $bookingRepository;

    /**
     * @var CustomFieldRepository
     */
    private $customFieldRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var BookingStatusRepository
     */
    private $bookingStatusRepository;
    /**
     * @var PaymentRepository
     */
    private $paymentRepository;
    /**
     * @var NotificationRepository
     */
    private $notificationRepository;
    /**
     * @var AddressRepository
     */
    private $addressRepository;
    /**
     * @var TaxRepository
     */
    private $taxRepository;
    /**
     * @var EServiceRepository
     */
    private $eServiceRepository;
    /**
     * @var EProviderRepository
     */
    private $eProviderRepository;
    /**
     * @var CouponRepository
     */
    private $couponRepository;
    /**
     * @var OptionRepository
     */
    private $optionRepository;
    /**
     * @var PaymentStatusRepository
     */
    private $paymentStatusRepository;
    /**
     *
     * @var EProviderLocationRepository
     */
    private $eProviderLocationRepository;

    public function __construct(
        BookingRepository $bookingRepo,
        CustomFieldRepository $customFieldRepo,
        UserRepository $userRepo
        ,
        BookingStatusRepository $bookingStatusRepo,
        NotificationRepository $notificationRepo,
        PaymentRepository $paymentRepo,
        AddressRepository $addressRepository,
        TaxRepository $taxRepository,
        EServiceRepository $eServiceRepository,
        EProviderRepository $eProviderRepository,
        CouponRepository $couponRepository,
        OptionRepository $optionRepository,
        PaymentStatusRepository $paymentStatusRepository,
        EProviderLocationRepository $eProviderLocationRepository
    ) {
        parent::__construct();
        $this->bookingRepository = $bookingRepo;
        $this->customFieldRepository = $customFieldRepo;
        $this->userRepository = $userRepo;
        $this->bookingStatusRepository = $bookingStatusRepo;
        $this->notificationRepository = $notificationRepo;
        $this->paymentRepository = $paymentRepo;
        $this->addressRepository = $addressRepository;
        $this->taxRepository = $taxRepository;
        $this->eServiceRepository = $eServiceRepository;
        $this->eProviderRepository = $eProviderRepository;
        $this->couponRepository = $couponRepository;
        $this->optionRepository = $optionRepository;
        $this->paymentStatusRepository = $paymentStatusRepository;
        $this->eProviderLocationRepository = $eProviderLocationRepository;
    }

    /**
     * Display a listing of the Booking.
     * GET|HEAD /bookings
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $this->bookingRepository->pushCriteria(new RequestCriteria($request));
            $this->bookingRepository->pushCriteria(new BookingsOfUserCriteria(auth()->id()));
            $this->bookingRepository->pushCriteria(new LimitOffsetCriteria($request));
        } catch (RepositoryException $e) {
            return $this->sendError($e->getMessage());
        }
        $bookings = $this->bookingRepository->all();

        return $this->sendResponse($bookings->toArray(), 'Bookings retrieved successfully');
    }

    /**
     * Display the specified Booking.
     * GET|HEAD /bookings/{id}
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show($id, Request $request)
    {
        try {
            $this->bookingRepository->pushCriteria(new RequestCriteria($request));
            $this->bookingRepository->pushCriteria(new LimitOffsetCriteria($request));
        } catch (RepositoryException $e) {
            return $this->sendError($e->getMessage());
        }
        $booking = $this->bookingRepository->findWithoutFail($id);
        if (empty($booking)) {
            return $this->sendError('Booking not found');
        }
        $this->filterModel($request, $booking);
        // Return the booking model directly; the response helper will serialize it
        return $this->sendResponse($booking, 'Booking retrieved successfully');


    }

    /**
     * Store a newly created Booking in storage.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $input = $request->all();
            // Ensure the booking is associated with the authenticated user
            // Without this, downstream payment flows may fail because payments.user_id is derived from booking->user_id
            if (auth()->check()) {
                $input['user_id'] = auth()->id();
            }
            $this->validate($request, [
                'address.address' => Address::$rules['address'],
                'address.longitude' => Address::$rules['longitude'],
                'address.latitude' => Address::$rules['latitude'],
            ]);
            $addressData = $input['address'];
            if (auth()->check() && !isset($addressData['user_id'])) {
                $addressData['user_id'] = auth()->id();
            }
            $address = $this->addressRepository->updateOrCreate(['address' => $addressData['address']], $addressData);
            if (empty($address)) {
                return $this->sendError(__('lang.not_found', ['operator', __('lang.address')]));
            } else {
                $input['address'] = $address;
            }
            $eService = $this->eServiceRepository->find($input['e_service']);
            $eProvider = $eService->eProvider;
            $taxes = $eProvider->taxes;
            $input['e_provider'] = $eProvider;
            $input['taxes'] = $taxes;
            $input['e_service'] = $eService;
            if (isset($input['options'])) {
                $input['options'] = $this->optionRepository->findWhereIn('id', $input['options']);
            }
            $input['booking_status_id'] = $this->bookingStatusRepository->find(1)->id;
            if (isset($input['coupon_id']) && !empty($input['coupon_id'])) {
                $input['coupon'] = $this->couponRepository->find($input['coupon_id']);
            } elseif (isset($input['coupon_code']) && !empty($input['coupon_code'])) {
                $input['coupon'] = $this->couponRepository->firstWhere(['code' => $input['coupon_code']]);
            } elseif (isset($input['coupon']) && is_array($input['coupon']) && isset($input['coupon']['id'])) {
                $input['coupon'] = $this->couponRepository->find($input['coupon']['id']);
            }
            $booking = $this->bookingRepository->create($input);
            try {
                $providerAddress = $eProvider->addresses()->first();
                if ($providerAddress) {
                    $this->eProviderLocationRepository->updateOrCreate(
                        ['e_provider_id' => $eProvider->id, 'booking_id' => $booking->id],
                        ['latitude' => $providerAddress->latitude, 'longitude' => $providerAddress->longitude]
                    );
                } else {
                    return $this->sendError('Provider address not found.');
                }
            } catch (ValidatorException $e) {
                return $this->sendError($e->getMessage());
            }
            try {
                $paymentMethod = $request->input('payment_method', $input['payment_method'] ?? 'card');
                $isCard = ($paymentMethod === 'card');
                // Defer vendor & client notifications for card payments until Stripe payment succeeds in StripeController::payBooking
                if (!$isCard) {
                    Notification::send($eProvider->users, new NewBooking($booking));
                    if ($booking->user) {
                        Notification::send([$booking->user], new NewBooking($booking));
                    }
                }
            } catch (\Exception $e) {
                \Log::warning('NewBooking notification failed: ' . $e->getMessage());
            }



        } catch (ValidationException $e) {
            return $this->sendError(array_values($e->errors()));
        } catch (ValidatorException | ModelNotFoundException | Exception $e) {
            return $this->sendError($e->getMessage());
        }

        // Return the booking model directly; the response helper will serialize it
        return $this->sendResponse($booking, __('lang.saved_successfully', ['operator' => __('lang.booking')]));
    }

    /**
     * Update the specified Booking in storage.
     *
     * @param int $id
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function update($id, Request $request): JsonResponse
    {
        $oldBooking = $this->bookingRepository->findWithoutFail($id);
        if (empty($oldBooking)) {
            return $this->sendError('Booking not found');
        }
        $input = $request->all();
        try {
            // ── Cancellation Flow ──
            $isCancellation = isset($input['booking_status_id'])
                && (int)$input['booking_status_id'] === 7
                && (int)$oldBooking->booking_status_id !== 7;

            if ($isCancellation) {
                $cancelledBy = $request->input('cancelled_by', 'customer');
                $waiveFee = filter_var($request->input('waive_fee', false), FILTER_VALIDATE_BOOLEAN);

                // Calculate cancellation fee
                $cancellation = CancellationService::calculate($oldBooking, $cancelledBy);

                // Apply fee (or waive it)
                $input['cancellation_fee'] = $waiveFee ? 0 : $cancellation['fee_amount'];
                $input['cancellation_reason'] = $request->input('cancellation_reason', null);
                $input['cancelled_at'] = now();
                $input['cancelled_by'] = $cancelledBy;
                $input['cancellation_fee_waived'] = $waiveFee;
                $input['cancel'] = true;

                $booking = $this->bookingRepository->update($input, $id);

                // Send dedicated cancellation notification to customer
                $cancellationData = $waiveFee
                    ? array_merge($cancellation, ['fee_amount' => 0, 'is_free' => true, 'label' => 'Fee waived'])
                    : $cancellation;

                try {
                    Notification::send([$booking->user], new BookingCancelledNotification($booking, $cancellationData));
                    // Also notify provider
                    if ($booking->e_provider && $booking->e_provider->users) {
                        Notification::send($booking->e_provider->users, new BookingCancelledNotification($booking, $cancellationData));
                    }
                } catch (\Exception $e) {
                    // Don't fail the cancellation if notification fails
                    \Log::warning('Cancellation notification failed: ' . $e->getMessage());
                }

                // Include cancellation details in the response
                $response = $booking->toArray();
                $response['cancellation_details'] = $cancellationData;

                return $this->sendResponse($response, __('lang.saved_successfully', ['operator' => __('lang.booking')]));
            }

            // ── Normal Status Update ──
            $booking = $this->bookingRepository->update($input, $id);
            if (isset($input['booking_status_id']) && $input['booking_status_id'] != $oldBooking->booking_status_id) {
                $newStatusId = (int) $input['booking_status_id'];

                try {
                    if ($newStatusId === 5) {
                        // Ready / Awaiting Client Confirmation -> notify client to validate
                        if ($booking->user) {
                            Notification::send([$booking->user], new StatusChangedBooking($booking));
                        }
                    } elseif ($newStatusId === 6) {
                        // Done -> notify both client (to review) and provider (funds released)
                        if ($booking->user) {
                            Notification::send([$booking->user], new StatusChangedBooking($booking));
                        }
                        if ($booking->e_provider && $booking->e_provider->users) {
                            Notification::send($booking->e_provider->users, new StatusChangedBooking($booking));
                        }
                    } elseif ($booking->bookingStatus->order < 40) {
                        Notification::send([$booking->user], new StatusChangedBooking($booking));
                    } else {
                        Notification::send($booking->e_provider->users, new StatusChangedBooking($booking));
                    }
                } catch (\Exception $e) {
                    \Log::warning('StatusChangedBooking notification failed: ' . $e->getMessage());
                }

                // Recalculate provider earnings when a booking is completed (Done/Ready)
                if (in_array($newStatusId, [5, 6])) {
                    event(new BookingChangedEvent($booking->e_provider));
                }

                // Check and award referral rewards when booking is completed
                if ($newStatusId === 6) {
                    try {
                        \App\Models\UserReferral::checkAndAwardQualification($booking);
                    } catch (\Exception $e) {
                        \Log::warning('Referral qualification check failed: ' . $e->getMessage());
                    }
                }
            }

        } catch (ValidatorException $e) {
            return $this->sendError($e->getMessage());
        }

        // Return the booking model directly; the response helper will serialize it
        return $this->sendResponse($booking, __('lang.saved_successfully', ['operator' => __('lang.booking')]));
    }

    /**
     * Client confirms job is done.
     * POST /api/bookings/{id}/confirm-done
     */
    public function confirmDone($id, Request $request): JsonResponse
    {
        $booking = $this->bookingRepository->findWithoutFail($id);
        if (empty($booking)) {
            return $this->sendError('Booking not found');
        }

        $user = auth()->user();
        $isCustomer = $user && (int)$booking->user_id === (int)$user->id;
        $isProvider = $user && $booking->e_provider && $booking->e_provider->users->contains('id', $user->id);
        $isAdmin = $user && method_exists($user,('hasRole')) && $user->hasRole('admin');

        if (!$isCustomer && !$isProvider && !$isAdmin) {
            return $this->sendError('Unauthorized to confirm this booking');
        }

        try {
            $booking = $this->bookingRepository->update(['booking_status_id' => 6], $id);

            // Recalculate provider earnings
            if ($booking->e_provider) {
                event(new BookingChangedEvent($booking->e_provider));
            }

            // Check and award referral rewards
            try {
                \App\Models\UserReferral::checkAndAwardQualification($booking);
            } catch (\Exception $e) {
                \Log::warning('Referral qualification check failed in confirmDone: ' . $e->getMessage());
            }

            // Notify both parties
            try {
                if ($booking->user) {
                    Notification::send([$booking->user], new StatusChangedBooking($booking));
                }
                if ($booking->e_provider && $booking->e_provider->users) {
                    Notification::send($booking->e_provider->users, new StatusChangedBooking($booking));
                }
            } catch (\Exception $e) {
                \Log::warning('Booking completion notification failed: ' . $e->getMessage());
            }

            return $this->sendResponse($booking, 'Booking marked as completed successfully!');
        } catch (\Exception $e) {
            return $this->sendError('Failed to confirm booking: ' . $e->getMessage());
        }
    }

    /**
     * Get a cancellation fee estimate for a booking before the user confirms.
     * GET /api/bookings/{id}/cancellation-estimate
     */
    public function cancellationEstimate($id, Request $request): JsonResponse
    {
        $booking = $this->bookingRepository->findWithoutFail($id);
        if (empty($booking)) {
            return $this->sendError('Booking not found');
        }

        $cancelledBy = $request->query('cancelled_by', 'customer');
        $estimate = CancellationService::calculate($booking, $cancelledBy);
        $estimate['policy'] = CancellationService::getPolicyDescription();

        return $this->sendResponse($estimate, 'Cancellation estimate retrieved');
    }

}
