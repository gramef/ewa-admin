<?php
/*
 * File name: PaymentAPIController.php
 * Last modified: 2021.11.01 at 22:25:44
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

namespace App\Http\Controllers\API;


use App\Events\BookingChangedEvent;
use App\Http\Controllers\Controller;
use App\Notifications\StatusChangedPayment;
use App\Repositories\BookingRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\PaymentMethodRepository;
use App\Repositories\WalletRepository;
use App\Repositories\WalletTransactionRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class PaymentController
 * @package App\Http\Controllers\API
 */
class PaymentAPIController extends Controller
{
    /** @var  PaymentRepository */
    private $paymentRepository;
    /**
     * @var BookingRepository
     */
    private $bookingRepository;

    /**
     * @var WalletTransactionRepository
     */
    private $walletTransactionRepository;
    /**
     * @var WalletRepository
     */
    private $walletRepository;
    /**
     * @var PaymentMethodRepository
     */
    private $paymentMethodRepository;

    public function __construct(PaymentRepository $paymentRepo, BookingRepository $bookingRepo, WalletTransactionRepository $walletTransactionRepository, WalletRepository $walletRepository, PaymentMethodRepository $paymentMethodRepository)
    {
        $this->paymentRepository = $paymentRepo;
        $this->bookingRepository = $bookingRepo;
        $this->walletTransactionRepository = $walletTransactionRepository;
        $this->walletRepository = $walletRepository;
        $this->paymentMethodRepository = $paymentMethodRepository;
    }

    /**
     * Display a listing of the Payment.
     * GET|HEAD /payments
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $this->paymentRepository->pushCriteria(new RequestCriteria($request));
            $this->paymentRepository->pushCriteria(new LimitOffsetCriteria($request));

            try {
                // Include commonly used relationships to avoid N+1 queries in clients
                $payments = $this->paymentRepository
                    ->with(['paymentMethod', 'paymentStatus', 'booking', 'booking.eService'])
                    ->all();
            } catch (\Exception $e) {
                // Fallback: load without deep relationships if they fail
                try {
                    $payments = $this->paymentRepository->all();
                } catch (\Exception $e2) {
                    return $this->sendResponse([], 'Payments retrieved successfully');
                }
            }

            return $this->sendResponse($payments->toArray(), 'Payments retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendResponse([], 'Payments retrieved successfully');
        }
    }

    /**
     * Store a newly created Payment in storage.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function cash(Request $request): JsonResponse
    {
        $input = $request->all();
        try {
            $booking = $this->bookingRepository->find($input['id']);
            $input['payment']['amount'] = $booking->getTotal();
            $input['payment']['description'] = __('lang.payment_booking_id') . $input['id'];
            $input['payment']['payment_status_id'] = 1;
            $input['payment']['user_id'] = $booking->user_id;
            // ensure payment method is set to Cash
            $cashMethod = $this->paymentMethodRepository->findWhere(['route' => '/Cash'])->first();
            if (!$cashMethod) {
                return $this->sendError(__('lang.not_found', ['operator' => __('lang.payment_method')]) . ' Cash');
            }
            $input['payment']['payment_method_id'] = $cashMethod->id;
            $payment = $this->paymentRepository->create($input['payment']);
            $booking = $this->bookingRepository->update(['payment_id' => $payment->id], $input['id']);
            Notification::send($booking->e_provider->users, new StatusChangedPayment($booking));

        } catch (ValidatorException $e) {
            return $this->sendError(__('lang.not_found', ['operator' => __('lang.payment')]));
        }

        // Return the payment model directly; the response helper will serialize it
        return $this->sendResponse($payment, __('lang.saved_successfully', ['operator' => __('lang.payment')]));
    }

    /**
     * Store a newly created Payment in storage.
     *
     * @param string $id
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function wallets(string $walletId, Request $request): JsonResponse
    {
        $input = $request->all();
        $transaction = [];
        try {
            $booking = $this->bookingRepository->find($input['id']);
            $wallet = $this->walletRepository->find($walletId);
            if ($wallet->currency->code == setting('default_currency_code')) {
                $input['payment']['amount'] = $booking->getTotal();
                $input['payment']['description'] = __('lang.payment_booking_id') . $input['id'];
                $input['payment']['payment_status_id'] = 2; // done
                $input['payment']['user_id'] = auth()->id();
                $transaction['wallet_id'] = $walletId;
                $transaction['user_id'] = $input['payment']['user_id'];
                $transaction['amount'] = $input['payment']['amount'];
                $transaction['description'] = __('lang.payment_booking_id') . $input['id'];
                $transaction['action'] = 'debit';
                $this->walletTransactionRepository->create($transaction);
                $payment = $this->paymentRepository->create($input['payment']);
                $booking = $this->bookingRepository->update(['payment_id' => $payment->id], $input['id']);
                //Notification::send($booking->e_provider->users, new StatusChangedPayment($booking));

            } else {
                return $this->sendError(__('lang.not_found', ['operator' => __('lang.wallet')]));
            }
        } catch (ValidatorException | ModelNotFoundException $e) {
            return $this->sendError(__('lang.not_found', ['operator' => __('lang.payment')]));
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
        // Return the payment model directly; the response helper will serialize it
        return $this->sendResponse($payment, __('lang.saved_successfully', ['operator' => __('lang.payment')]));
    }

    /**
     * Update the specified Payment in storage.
     *
     * @param int $id
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function update(int $id, Request $request): JsonResponse
    {
        // todo payment of provider
        $payment = $this->paymentRepository->findWithoutFail($id);
        if (empty($payment)) {
            return $this->sendError(__('lang.not_found', ['operator' => __('lang.payment')]));
        }
        $input = $request->except('amount', 'payment_method_id', 'id');
        try {
            $this->paymentRepository->update($input, $id);
            $payment = $this->paymentRepository->with(['paymentMethod', 'paymentStatus'])->find($id);
            //Notification::send($payment->booking->user, new StatusChangedPayment($payment->booking));

            event(new BookingChangedEvent($payment->booking->e_provider));
        } catch (ValidatorException $e) {
            return $this->sendError($e->getMessage());
        }
        // Return the payment model directly; the response helper will serialize it
        return $this->sendResponse($payment, __('lang.saved_successfully', ['operator' => __('lang.booking')]));
    }

    public function byMonth()
    {
        // Always work with a Collection to avoid calling methods on arrays
        $payments = collect();
        if (!empty($this->paymentRepository)) {
            $payments = $this->paymentRepository->orderBy("created_at", 'asc')->all()->map(function ($row) {
                $row['month'] = $row['created_at']->format('M');
                return $row;
            })->groupBy('month')->map(function ($row) {
                return $row->sum('amount');
            });
        }
        // Convert to simple arrays for response: first totals, then months (keys)
        $values = $payments->values()->all();
        $keys = $payments->keys()->all();
        return $this->sendResponse([$values, $keys], 'Payment retrieved successfully');
    }

    /**
     * Display the specified Payment details.
     * GET /payments/{id}
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $payment = $this->paymentRepository
                ->with(['paymentMethod', 'paymentStatus', 'booking', 'booking.eService', 'booking.eService.eProvider'])
                ->find($id);
        } catch (ModelNotFoundException $e) {
            return $this->sendError(__('lang.not_found', ['operator' => __('lang.payment')]));
        } catch (RepositoryException $e) {
            return $this->sendError($e->getMessage());
        }

        if (empty($payment)) {
            return $this->sendError(__('lang.not_found', ['operator' => __('lang.payment')]));
        }

        // Return the payment model directly; the response helper will serialize it
        return $this->sendResponse($payment, 'Payment retrieved successfully');
    }
}
