@extends('emails.vendor.layout')

@section('title', 'Application Received — EWA')

@section('content')
<h2>Hi {{ $vendorName }},</h2>

<p>Thank you for registering as a stylist on EWA. We have received your application and our team will review it within 24 to 48 hours.</p>

<p>We may be in touch to request some additional information as part of our vetting process. Please keep an eye on your inbox.</p>

<div class="info-box">
    <p><strong>What happens next?</strong> Our team reviews your submitted documents and profile. You will receive an email once your application has been processed.</p>
</div>

<p>We are excited to potentially have you as part of the EWA stylist community.</p>

<p style="margin-top:28px;">The EWA Team</p>
@endsection
