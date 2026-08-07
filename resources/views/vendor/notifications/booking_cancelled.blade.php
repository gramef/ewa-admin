@component('mail::message')

{{-- Header --}}
# ❌ Booking Cancelled

Your booking **#{{ $booking->id }}** has been cancelled.

---

@component('mail::panel')
## Booking Details

| | |
|:---|---:|
| **Service** | {{ $serviceName }} |
| **Stylist** | {{ $providerName }} |
| **Scheduled For** | {{ \Carbon\Carbon::parse($booking->booking_at)->format('l, j F Y \a\t g:i A') }} |
@if($booking->address && $booking->address->address)
| **Location** | {{ $booking->address->address }} |
@endif
@if($booking->cancelled_by)
| **Cancelled By** | {{ ucfirst($booking->cancelled_by) }} |
@endif
@if($booking->cancellation_reason)
| **Reason** | {{ $booking->cancellation_reason }} |
@endif
@endcomponent

{{-- Cancellation Fee Section --}}
@if(!empty($cancellation) && isset($cancellation['fee_amount']))
@if($cancellation['fee_amount'] > 0)
@component('mail::panel')
## ⚠️ Cancellation Fee

A cancellation fee has been applied because this booking was cancelled with less than **{{ $cancellation['hours_remaining'] ?? 0 }} hours** notice.

| | |
|:---|---:|
| **Service Cost** | £{{ number_format($cancellation['subtotal'] ?? 0, 2) }} |
| **Fee** | {{ $cancellation['label'] ?? 'Cancellation fee' }} |
| **Amount Charged** | **£{{ number_format($cancellation['fee_amount'], 2) }}** |

@if(isset($cancellation['fee_percent']) && $cancellation['fee_percent'] < 100)
A partial refund of **£{{ number_format(($cancellation['subtotal'] ?? 0) - $cancellation['fee_amount'], 2) }}** will be processed.
@endif
@endcomponent
@else
@component('mail::panel')
## ✅ No Cancellation Fee

This booking was cancelled with more than 48 hours notice, so **no fee applies**.

@if($booking->payment && $booking->payment->amount > 0)
A **full refund** of your payment will be processed.
@endif
@endcomponent
@endif
@endif

{{-- Cancellation Policy Reminder --}}
@component('mail::panel')
### Our Cancellation Policy

| Notice Period | Fee |
|:---|:---|
| More than 48 hours | **Free** — full refund |
| 24–48 hours before | **50%** of service cost |
| Less than 24 hours / no-show | **100%** — no refund |

We understand plans change — this policy helps protect our stylists' time and livelihood.
@endcomponent

@component('mail::button', ['url' => url('/'), 'color' => 'primary'])
Book Again
@endcomponent

Thank you for using {{ setting('app_name', 'EWA') }}.

@lang('Regards'),<br>
{{ setting('app_name', config('app.name')) }}

@endcomponent
