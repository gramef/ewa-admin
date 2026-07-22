@extends('emails.vendor.layout')

@section('title', 'Getting Set Up on EWA')

@section('content')
<h2>Hi {{ $vendorName }},</h2>

<p>We wanted to check in and make sure you are getting set up comfortably on EWA.</p>

<p>A few things worth checking on your dashboard:</p>

<ul>
    <li><strong>Have you set your availability hours?</strong> Clients can only book you when your schedule is visible.</li>
    <li><strong>Are all your services listed with correct pricing?</strong></li>
    <li><strong>Does your profile photo and gallery show your work at its best?</strong></li>
</ul>

<p style="text-align:center;">
    <a href="{{ $vendorPwaUrl }}" class="cta-button">Open Your Dashboard</a>
</p>

<p>If you need any help, just reply to this message or email us at <a href="mailto:support@ewaofficialapp.com" style="color:#c8956c;">support@ewaofficialapp.com</a>.</p>

<p>Looking forward to seeing you get your first booking.</p>

<p style="margin-top:28px;">The EWA Team</p>
@endsection
