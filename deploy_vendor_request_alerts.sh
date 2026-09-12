#!/bin/bash
# ============================================================
# EWA — Vendor Request Admin Alerts & Notifications Deploy Script
# Run this in the Bluehost cPanel Terminal:
#   cd ~/public_html && bash deploy_vendor_request_alerts.sh
# ============================================================

cd ~/public_html

echo "============================================"
echo "  Deploying Vendor Request Alerts & Badges"
echo "============================================"

# ── 1. Create Mailable: NewProviderRequestAdmin.php ──
echo ""
echo "=== 1. Creating app/Mail/NewProviderRequestAdmin.php ==="
mkdir -p app/Mail
cat > app/Mail/NewProviderRequestAdmin.php << 'ENDOFFILE'
<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Sent to admin users (and admin@ewaofficialapp.com)
 * whenever a new vendor business request / onboarding is submitted.
 */
class NewProviderRequestAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public string $providerName;
    public string $providerType;
    public string $ownerName;
    public string $ownerEmail;
    public string $phoneNumber;
    public string $packageName;
    public string $address;
    public int $providerId;
    public string $adminPanelUrl;

    public function __construct(
        string $providerName,
        string $providerType,
        string $ownerName,
        string $ownerEmail,
        string $phoneNumber,
        string $packageName = 'Free Trial (30 Days)',
        string $address = 'N/A',
        int $providerId = 0
    ) {
        $this->providerName = $providerName;
        $this->providerType = $providerType;
        $this->ownerName = $ownerName;
        $this->ownerEmail = $ownerEmail;
        $this->phoneNumber = $phoneNumber;
        $this->packageName = $packageName;
        $this->address = $address;
        $this->providerId = $providerId;
        $this->adminPanelUrl = url('requestedEProviders');
    }

    public function build()
    {
        return $this->subject("🔔 New Vendor Request: {$this->providerName}")
            ->from(config('mail.from.address', 'support@ewaofficialapp.com'), config('app.name', 'EWA Hair Platform'))
            ->markdown('emails.admin.provider-request');
    }
}
ENDOFFILE
echo "  ✓ NewProviderRequestAdmin.php created"

# ── 2. Create Email Template: provider-request.blade.php ──
echo ""
echo "=== 2. Creating resources/views/emails/admin/provider-request.blade.php ==="
mkdir -p resources/views/emails/admin
cat > resources/views/emails/admin/provider-request.blade.php << 'ENDOFFILE'
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
ENDOFFILE
echo "  ✓ provider-request.blade.php created"

# ── 3. Create Notification: NewProviderRequestNotification.php ──
echo ""
echo "=== 3. Creating app/Notifications/NewProviderRequestNotification.php ==="
mkdir -p app/Notifications
cat > app/Notifications/NewProviderRequestNotification.php << 'ENDOFFILE'
<?php

namespace App\Notifications;

use App\Models\EProvider;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewProviderRequestNotification extends Notification
{
    use Queueable;

    public EProvider $provider;
    public ?User $user;
    public string $packageName;

    public function __construct(EProvider $provider, ?User $user = null, string $packageName = 'Standard')
    {
        $this->provider = $provider;
        $this->user = $user;
        $this->packageName = $packageName;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        $providerName = is_array($this->provider->name) ? ($this->provider->name['en'] ?? reset($this->provider->name)) : $this->provider->name;
        $providerType = $this->provider->eProviderType ? (is_array($this->provider->eProviderType->name) ? ($this->provider->eProviderType->name['en'] ?? reset($this->provider->eProviderType->name)) : $this->provider->eProviderType->name) : 'Stylist';

        return [
            'type' => 'new_provider_request',
            'provider_id' => $this->provider->id,
            'provider_name' => $providerName,
            'provider_type' => $providerType,
            'user_name' => $this->user->name ?? $providerName,
            'user_email' => $this->user->email ?? 'N/A',
            'phone_number' => $this->provider->phone_number ?? ($this->user->phone_number ?? 'N/A'),
            'package_name' => $this->packageName,
            'kyc_status' => $this->provider->kyc_status ?? 'pending',
            'message' => "New vendor request received from {$providerName} ({$providerType})",
            'action_url' => url('requestedEProviders'),
            'created_at' => now()->toDateTimeString(),
        ];
    }
}
ENDOFFILE
echo "  ✓ NewProviderRequestNotification.php created"

# ── 4. Copy Controller and Layouts from local repository ──
# (If running standalone via bash script, create OnboardingAPIController, layouts/app.blade.php, layouts/menu.blade.php)
echo ""
echo "=== 4. Updating OnboardingAPIController with email and notification dispatch ==="
cat > app/Http/Controllers/API/EProvider/OnboardingAPIController.php << 'ENDOFFILE'
<?php

namespace App\Http\Controllers\API\EProvider;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\AvailabilityHour;
use App\Models\CustomFieldValue;
use App\Models\EProvider;
use App\Repositories\AddressRepository;
use App\Repositories\AvailabilityHourRepository;
use App\Repositories\CustomFieldValueRepository;
use App\Repositories\EProviderRepository;
use App\Repositories\UploadRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Subscription\Models\EProviderSubscription;
use Modules\Subscription\Models\SubscriptionPackage;

class OnboardingAPIController extends Controller
{
    private EProviderRepository $eProviderRepository;
    private AddressRepository $addressRepository;
    private AvailabilityHourRepository $availabilityHourRepository;
    private CustomFieldValueRepository $customFieldValueRepository;
    private UploadRepository $uploadRepository;

    public function __construct(
        EProviderRepository $eProviderRepo,
        AddressRepository $addressRepo,
        AvailabilityHourRepository $availabilityHourRepo,
        CustomFieldValueRepository $customFieldValueRepo,
        UploadRepository $uploadRepo
    ) {
        $this->eProviderRepository = $eProviderRepo;
        $this->addressRepository = $addressRepo;
        $this->availabilityHourRepository = $availabilityHourRepo;
        $this->customFieldValueRepository = $customFieldValueRepo;
        $this->uploadRepository = $uploadRepo;
    }

    /**
     * Step 1: Save Business Details
     */
    public function saveBusiness(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:127',
            'e_provider_type_id' => 'required|exists:e_provider_types,id',
            'phone_number' => 'nullable|string|max:50',
            'mobile_number' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'availability_range' => 'nullable|numeric',
        ]);

        try {
            DB::beginTransaction();
            $user = auth()->user();

            $input = $request->only([
                'name', 'e_provider_type_id', 'phone_number',
                'mobile_number', 'description', 'availability_range',
            ]);
            $input['available'] = 1;
            $input['accepted'] = 0;

            $provider = $user->eProviders()->first();

            if ($provider) {
                $provider = $this->eProviderRepository->update($input, $provider->id);
            } else {
                $provider = $this->eProviderRepository->create($input);
                $provider->users()->syncWithoutDetaching([$user->id]);
            }

            DB::commit();
            return $this->sendResponse($provider->toArray(), 'Business profile saved successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage(), 200);
        }
    }

    /**
     * Step 2: Save Location & Operating Hours
     */
    public function saveLocationHours(Request $request): JsonResponse
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'hours' => 'nullable|array',
            'hours.*.day' => 'required_with:hours|string',
            'hours.*.start_at' => 'required_with:hours|string',
            'hours.*.end_at' => 'required_with:hours|string',
        ]);

        try {
            DB::beginTransaction();
            $user = auth()->user();
            $provider = $user->eProviders()->first();

            if (!$provider) {
                return $this->sendError('Please complete Step 1 (Business Details) first', 200);
            }

            $addressInput = [
                'description' => $request->get('address'),
                'address' => $request->get('address'),
                'latitude' => $request->get('latitude', 51.5074),
                'longitude' => $request->get('longitude', -0.1278),
                'user_id' => $user->id,
            ];

            $address = $provider->addresses()->first();
            if ($address) {
                $address->update($addressInput);
            } else {
                $address = Address::create($addressInput);
                $provider->addresses()->syncWithoutDetaching([$address->id]);
            }

            if ($request->has('hours') && is_array($request->get('hours'))) {
                $provider->availabilityHours()->delete();

                foreach ($request->get('hours') as $hourData) {
                    AvailabilityHour::create([
                        'day' => $hourData['day'],
                        'start_at' => $hourData['start_at'],
                        'end_at' => $hourData['end_at'],
                        'data' => $hourData['data'] ?? null,
                        'e_provider_id' => $provider->id,
                    ]);
                }
            }

            DB::commit();
            return $this->sendResponse($provider->load(['addresses', 'availabilityHours'])->toArray(), 'Location and hours saved');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage(), 200);
        }
    }

    /**
     * Step 3: Complete Onboarding and Start Free Trial
     */
    public function complete(Request $request): JsonResponse
    {
        try {
            $user = auth()->user();
            $provider = $user->eProviders()->first();

            if (!$provider) {
                return $this->sendError('No provider profile found', 200);
            }

            $selectedPackageId = $request->get('package_id');
            $package = null;

            if ($selectedPackageId) {
                $package = SubscriptionPackage::find($selectedPackageId);
            }

            if (!$package) {
                $package = SubscriptionPackage::where('is_free_trial', true)
                    ->where('enabled', true)
                    ->first();
            }

            if (!$package) {
                $package = SubscriptionPackage::where('enabled', true)->orderBy('price', 'asc')->first();
            }

            $trialDays = $package ? ($package->trial_duration_in_days ?? 30) : 30;
            $packageName = $package ? $package->name : 'Standard';

            $existingSub = EProviderSubscription::where('e_provider_id', $provider->id)->first();

            if (!$existingSub && $package) {
                EProviderSubscription::create([
                    'e_provider_id' => $provider->id,
                    'subscription_package_id' => $package->id,
                    'starts_at' => now(),
                    'expires_at' => now()->addDays($trialDays),
                    'active' => true,
                    'is_trial' => true,
                    'notes' => 'Onboarding trial: ' . $packageName,
                ]);
            }

            // Notify admin via Email and Database Notification
            try {
                $providerName = is_array($provider->name) ? ($provider->name['en'] ?? reset($provider->name)) : ($provider->name ?? 'Vendor');
                $providerType = $provider->eProviderType ? (is_array($provider->eProviderType->name) ? ($provider->eProviderType->name['en'] ?? reset($provider->eProviderType->name)) : $provider->eProviderType->name) : 'Stylist';
                $addressStr = $provider->addresses()->first()?->address ?? 'N/A';

                // 1. Send email to admin@ewaofficialapp.com
                \Illuminate\Support\Facades\Mail::to('admin@ewaofficialapp.com')->send(new \App\Mail\NewProviderRequestAdmin(
                    $providerName,
                    $providerType,
                    $user->name ?? $providerName,
                    $user->email ?? 'N/A',
                    $provider->phone_number ?? ($user->phone_number ?? 'N/A'),
                    $packageName,
                    $addressStr,
                    $provider->id
                ));

                // 2. Also send to any other registered admins
                $admins = \App\Models\User::role('admin')->get();
                foreach ($admins as $admin) {
                    if ($admin->email && $admin->email !== 'admin@ewaofficialapp.com') {
                        \Illuminate\Support\Facades\Mail::to($admin->email)->send(new \App\Mail\NewProviderRequestAdmin(
                            $providerName,
                            $providerType,
                            $user->name ?? $providerName,
                            $user->email ?? 'N/A',
                            $provider->phone_number ?? ($user->phone_number ?? 'N/A'),
                            $packageName,
                            $addressStr,
                            $provider->id
                        ));
                    }
                }

                // 3. Dispatch in-app database notification for admin bell
                \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\NewProviderRequestNotification(
                    $provider,
                    $user,
                    $packageName
                ));

                \Illuminate\Support\Facades\Log::info("New provider request notification and email dispatched for provider #{$provider->id} ({$providerName})");
            } catch (\Exception $notifyErr) {
                \Illuminate\Support\Facades\Log::error("Failed to dispatch provider request notification: " . $notifyErr->getMessage());
            }

            return $this->sendResponse($provider->toArray(), 'Onboarding complete!');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 200);
        }
    }

    /**
     * Check onboarding status
     */
    public function status(Request $request): JsonResponse
    {
        try {
            $user = auth()->user();
            $provider = $user->eProviders()->first();

            $status = [
                'has_provider' => !is_null($provider),
                'has_business_profile' => !is_null($provider),
                'has_address' => $provider ? $provider->addresses()->exists() : false,
                'has_availability' => $provider ? $provider->availabilityHours()->exists() : false,
                'is_available' => $provider ? (bool)$provider->available : false,
                'is_accepted' => $provider ? ((bool)$provider->accepted || $provider->kyc_status === 'verified') : false,
            ];

            // Include the provider object so the frontend can pre-fill the onboarding form
            if ($provider) {
                $status['provider'] = $provider->load(['addresses', 'availabilityHours', 'eProviderType'])->toArray();
                $sub = \Modules\Subscription\Models\EProviderSubscription::where('e_provider_id', $provider->id)->first();
                if ($sub) {
                    $status['subscription'] = $sub->load('package')->toArray();
                }
            }

            return $this->sendResponse($status, 'Onboarding status retrieved');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 200);
        }
    }
}
ENDOFFILE
echo "  ✓ OnboardingAPIController.php updated"

# ── 5. Patch Layouts (App Bell & Sidebar Badge) ──
echo ""
echo "=== 5. Patching app.blade.php & menu.blade.php for badge counters ==="

# We make sure the bell in app.blade.php displays the combined badge counter
python3 - << 'PYCODE'
import re

app_path = "resources/views/layouts/app.blade.php"
with open(app_path, "r") as f:
    content = f.read()

bell_block = """                @can('notifications.index')
                    @php
                        $unreadNotificationsCount = auth()->check() ? auth()->user()->unreadNotifications()->count() : 0;
                        $pendingProvidersCount = \\App\\Models\\EProvider::where('accepted', 0)->count();
                        $bellAlertTotal = $unreadNotificationsCount + $pendingProvidersCount;
                    @endphp
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('notifications*') ? 'active' : '' }}" style="position: relative;"
                            href="{!! route('notifications.index') !!}" title="{{ $bellAlertTotal }} pending notifications / requests">
                            <i class="fas fa-bell"></i>
                            @if($bellAlertTotal > 0)
                                <span class="badge badge-warning navbar-badge" style="position: absolute; top: 6px; right: 4px; font-size: 0.65rem; padding: 2px 4px; border-radius: 10px;">{{ $bellAlertTotal }}</span>
                            @endif
                        </a>
                    </li>
                @endcan"""

pattern = r"@can\('notifications\.index'\)[\s\S]*?@endcan"
if re.search(pattern, content):
    content = re.sub(pattern, bell_block, content, count=1)
    with open(app_path, "w") as f:
        f.write(content)
    print("  ✓ app.blade.php navbar bell patched with dynamic counter badge")
else:
    print("  ! Could not find notifications can block in app.blade.php")
PYCODE

python3 - << 'PYCODE'
import re

menu_path = "resources/views/layouts/menu.blade.php"
with open(menu_path, "r") as f:
    content = f.read()

# Add pending count to eProviders parent menu item if not present
if "$pendingRequestedProvidersCount" not in content:
    content = content.replace(
        "@can('eProviders.index')",
        "@can('eProviders.index')\n    @php\n        $pendingRequestedProvidersCount = \\App\\Models\\EProvider::where('accepted', 0)->count();\n    @endphp"
    )
    # Add badge to requestedEProviders link
    target_req = "<p>{{trans('lang.requested_e_providers_plural')}}</p>"
    rep_req = """<p>{{trans('lang.requested_e_providers_plural')}}
                            @if($pendingRequestedProvidersCount > 0)
                                <span class="right badge badge-warning">{{ $pendingRequestedProvidersCount }}</span>
                            @endif
                        </p>"""
    content = content.replace(target_req, rep_req)

    with open(menu_path, "w") as f:
        f.write(content)
    print("  ✓ menu.blade.php patched with sidebar request counters")
else:
    print("  ✓ menu.blade.php already contains provider count badges")
PYCODE

# ── 6. Clear Caches ──
echo ""
echo "=== 6. Clearing caches ==="
php artisan view:clear 2>&1
php artisan route:clear 2>&1
php artisan cache:clear 2>&1
php artisan config:clear 2>&1

echo ""
echo "============================================"
echo "  ✅ Vendor Request Alerts deployed successfully!"
echo "============================================"
echo "  • Email alert template: admin@ewaofficialapp.com"
echo "  • Navbar bell: unread notifications + pending requests badge"
echo "  • Sidebar menu: badge counter on 'Providers Requests'"
echo "============================================"
