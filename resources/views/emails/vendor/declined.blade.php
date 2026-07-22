@extends('emails.vendor.layout')

@section('title', 'EWA Application Update')

@section('content')
<h2>Hi {{ $vendorName }},</h2>

<p>Thank you for your interest in joining EWA and for taking the time to apply.</p>

<p>After reviewing your application, we are unfortunately unable to approve your listing at this time.</p>

@if(!empty($reason))
<div class="info-box">
    <p><strong>Reason:</strong> {{ $reason }}</p>
</div>
@endif

<p>You are welcome to reapply in the future if your circumstances change.</p>

<p>Thank you again for your interest in EWA.</p>

<p style="margin-top:28px;">The EWA Team</p>
@endsection
