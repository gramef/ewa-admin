@extends('emails.vendor.layout')

@section('title', 'Action Required — EWA Application')

@section('content')
<h2>Hi {{ $vendorName }},</h2>

<p>Thank you for applying to join EWA. To complete your vetting, please send us the following:</p>

<ol>
    <li><strong>Proof of your right to work in the UK</strong> — passport, BRP, or Home Office Share Code from <a href="https://www.gov.uk/prove-right-to-work" style="color:#c8956c;">gov.uk/prove-right-to-work</a></li>
    <li><strong>Portfolio images</strong> — at least 5 photos of your own work across at least 2 services you intend to offer on EWA</li>
</ol>

@if(!empty($additionalNotes))
<div class="info-box">
    <p><strong>Note from our team:</strong> {{ $additionalNotes }}</p>
</div>
@endif

<p>Please reply with these attached. We aim to complete your review within 2 working days.</p>

<p>You can also upload documents directly through your vendor dashboard:</p>

<p style="text-align:center;">
    <a href="{{ $vendorPwaUrl }}/#/kyc" class="cta-button">Upload Documents</a>
</p>

<p style="margin-top:28px;">The EWA Team</p>
@endsection
