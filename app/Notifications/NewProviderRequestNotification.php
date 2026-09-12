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
