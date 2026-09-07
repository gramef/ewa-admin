@component('mail::message')
# New KYC Verification Submitted

A vendor has completed their identity verification and is awaiting your review.

**Vendor Details:**

| | |
|---|---|
| **Name** | {{ $vendorName }} |
| **Email** | {{ $vendorEmail }} |
| **Method** | {{ ucfirst($verificationMethod) === 'Persona' ? '🤳 Persona (Selfie + Gov ID)' : '📄 Document Upload' }} |
| **Provider ID** | #{{ $providerId }} |
| **Submitted** | {{ now()->format('d M Y H:i') }} |

@component('mail::button', ['url' => $adminPanelUrl, 'color' => 'primary'])
Review KYC Now
@endcomponent

Please review and approve/reject within 24–48 hours as per the EWA vendor onboarding SOP.

Thanks,<br>
{{ config('app.name', 'EWA Hair Platform') }}

<small style="color: #999;">This is an automated notification. You are receiving this because you are an admin on the EWA platform.</small>
@endcomponent
