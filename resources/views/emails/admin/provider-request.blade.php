@component('mail::message')
# 🔔 New Vendor Application Received

A new vendor has submitted an application to join the EWA Hair Platform and is awaiting review.

**Application Details:**

| | |
|---|---|
| **Business Name** | **{{ $providerName }}** |
| **Provider Type** | {{ $providerType }} |
| **Contact Person** | {{ $ownerName }} |
| **Email** | {{ $ownerEmail }} |
| **Phone** | {{ $phoneNumber }} |
| **Address** | {{ $address }} |
| **Selected Plan** | {{ $packageName }} |
| **Provider ID** | #{{ $providerId }} |
| **Submitted** | {{ now()->format('d M Y H:i') }} |

@component('mail::button', ['url' => $adminPanelUrl, 'color' => 'primary'])
View Provider Request
@endcomponent

Please review their business profile and verify their KYC status before accepting the application.

Thanks,<br>
{{ config('app.name', 'EWA Hair Platform') }}

<small style="color: #999;">This automated alert was sent to admin@ewaofficialapp.com and platform administrators.</small>
@endcomponent
