<?php
/*
 * File name: StripeController.php
 * Last modified: 2021.05.07 at 19:12:31
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

namespace App\Http\Controllers;

use App\Events\BookingChangedEvent;
use App\Notifications\StatusChangedBooking;
use App\Notifications\StatusChangedPayment;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Prettus\Validator\Exceptions\ValidatorException;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripeController extends ParentBookingController
{

    private $stripePaymentMethodId;

    public function __init()
    {

    }

    public function index()
    {
        return view('home');
    }

    public function checkout(Request $request)
    {
        $this->booking = $this->bookingRepository->findWithoutFail($request->get('booking_id'));
        if (empty($this->booking)) {
            Flash::error("Error processing Stripe payment for your booking");
            return redirect(route('payments.failed'));
        }
        return view('payment_methods.stripe_charge', ['booking' => $this->booking]);
    }

    public function paySuccess(Request $request, int $bookingId, string $paymentMethodId)
    {
        $this->booking = $this->bookingRepository->findWithoutFail($bookingId);
        $this->stripePaymentMethodId = $paymentMethodId;

        if (empty($this->booking)) {
            Flash::error("Error processing Stripe payment for your booking");
            return redirect(route('payments.failed'));
        } else {
            try {
                $stripeCart = $this->getBookingData();
                $intent = PaymentIntent::create(array_merge($stripeCart, [
                    'confirm' => true,
                    'automatic_payment_methods' => [
                        'enabled' => true,
                    ],
                    'return_url' => route('payments.stripe.return'),
                ]));
                Log::info($intent->status);
                if (($intent->status === 'succeeded') || ($intent->status === 'requires_action')){
                    $this->paymentMethodId = 7; // Stripe method
                    $this->createBooking();
                    Notification::send($this->booking->user, new StatusChangedPayment($this->booking));
                    return response()->json(['client_secret' => $intent->client_secret]);
                }

                return $this->sendError('Payment failed or requires action.');

            } catch (ApiErrorException $e) {
                Log::info($e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile());
                return $this->sendError($e->getMessage());
            }
        }
    }


    /**
     * Set cart data for processing payment on Stripe.
     */
    private function getBookingData(): array
    {
        $data = [];
        $amount = $this->booking->getTotal();
        $data['amount'] = (int)($amount * 100);
        $data['payment_method'] = $this->stripePaymentMethodId;
        $data['currency'] = setting('default_currency_code');

        return $data;
    }


    public function createPaymentIntent(Request $request)
    {
        $booking = $this->bookingRepository->findByField('id', $request->input('booking_id'))->first();
        Stripe::setApiKey( setting('stripe_secret'));

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $booking->getTotal() * 100,
                'currency' => setting('default_currency_code'),
                'payment_method_types' => ['card'],
                'receipt_email' => $booking->user->email,
                'metadata' => [
                    'booking_id' => $booking->id,
                ],
                'description' => 'Booking payment for booking ID ' . $booking->id,


            ]);

            return response()->json(['clientSecret' => $paymentIntent->client_secret]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function payBooking(Request $request)
    {
        $intent = $request->input('payment_intent');
        Log::info($intent);
        $booking = $this->bookingRepository->findByField('id', $request->input('booking_id'))->first();
        if (($intent == 'Succeeded') || ($intent == 'requires_action')){
            $this->paymentMethodId = 7; // Stripe method
            try {
                $input['amount'] = $booking->getTotal();
                $input['description'] = trans("lang.done");
                $input['payment_status_id'] = 2;
                $input['payment_method_id'] = $this->paymentMethodId;
                $input['user_id'] = $booking->user_id;
                try {
                    $payment = $this->paymentRepository->create($input);
                } catch (ValidatorException $e) {
                    Log::error($e->getMessage());
                }
                if ($payment != null) {
                    $this->bookingRepository->update(['payment_id' => $payment->id],$booking->id);
                    event(new BookingChangedEvent($booking->e_provider));
                }
            } catch (ValidatorException $e) {
                Log::error($e->getMessage());
            }
            // Ensure booking has payment relation loaded for notification
            if (isset($payment) && $payment) {
                $payment->load('paymentStatus');
                $booking->setRelation('payment', $payment);
            } else {
                // Fallback: reload booking with payment relationships
                $booking = $this->bookingRepository->with(['payment.paymentStatus','user'])->find($booking->id);
            }
            // Structured logs to avoid casting objects to strings
            if ($booking && $booking->payment) {
                Log::info('Payment relation loaded', [
                    'booking_id' => $booking->id,
                    'payment_id' => $booking->payment->id,
                    'payment_status' => optional($booking->payment->paymentStatus)->status,
                ]);
            } else {
                Log::info('Payment relation missing', [
                    'booking_id' => optional($booking)->id,
                ]);
            }
            Notification::send($booking->user, new StatusChangedPayment($booking));
            return response()->json(['intent' => $intent]);
        }
        else {
            return response()->json(['error' => 'Payment failed']);
        }
    }
}