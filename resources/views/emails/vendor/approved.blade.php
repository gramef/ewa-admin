@extends('emails.vendor.layout')

@section('title', 'Welcome to EWA — You Are Now Live')

@section('content')
<h2>Hi {{ $vendorName }},</h2>

<p>Congratulations — your application has been approved and your profile is now live on EWA. 🎉</p>

<p>Here is what to do next to get your first booking:</p>

<ol>
    <li><strong>Log in to your vendor dashboard</strong> at <a href="{{ $vendorPwaUrl }}" style="color:#c8956c;">{{ $vendorPwaUrl }}</a></li>
    <li><strong>Check your profile</strong> — business name, description, photo, and services</li>
    <li><strong>Set your availability hours</strong> so clients can book you</li>
    <li><strong>Review your service listings</strong> and pricing</li>
</ol>

<p style="text-align:center;">
    <a href="{{ $vendorPwaUrl }}" class="cta-button">Go to Your Dashboard</a>
</p>

<div class="info-box">
    <p><strong>A few things to know:</strong></p>
    <p style="margin-top:8px;">• Respond to booking requests within 2 hours</p>
    <p>• Your earnings go into your EWA wallet and you can withdraw at any time</p>
    <p>• For help, contact our support team at <a href="mailto:support@ewaofficialapp.com" style="color:#c8956c;">support@ewaofficialapp.com</a></p>
</div>

<p>We are delighted to have you as part of the EWA stylist community. Welcome.</p>

<p style="margin-top:28px;">The EWA Team</p>
@endsection
