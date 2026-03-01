<?php
/*
 * File name: NewBooking.php
 * Last modified: 2021.11.01 at 22:25:44
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

namespace App\Notifications;

use App\Models\Booking;
use App\Models\EProvider;
use App\Models\EProviderPayout;
use Benwilkins\FCM\FcmMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class EProviderPayoutPaid extends Notification
{
    use Queueable;

    /**
     * @var EProvider
     */
    private EProvider $eProvider;

    /**
     * @var EProviderPayout
     */
    private EProviderPayout $eProviderPayout;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(EProvider $eProvider, EProviderPayout $eProviderPayout)
    {
        //
        $this->eProvider = $eProvider;
        $this->eProviderPayout = $eProviderPayout;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $types = ['database'];
        if (setting('enable_notifications', false)) {
            array_push($types, 'fcm');
        }
        if (setting('enable_email_notifications', false)) {
            array_push($types, 'mail');
        }
        return $types;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->markdown("notifications::e_provider_payout", ['eProviderPayout' => $this->eProviderPayout, 'eProvider' => $this->eProvider])
            ->subject(trans('lang.notification_e_provider_payout_paid', ['e_provider_payout_id' => $this->eProviderPayout->id, 'user_name' => $this->eProvider->name]) . " | " . setting('app_name', ''))
            ->greeting(trans('lang.notification_e_provider_payout_paid', ['e_provider_payout_id' => $this->eProviderPayout->id, 'user_name' => $this->eProvider->name]))
            ->action(trans('lang.e_provider_payout_details'), route('eProviderPayouts.edit', $this->eProvider->id));
    }

    public function toFcm($notifiable): FcmMessage
    {
        $message = new FcmMessage();
        $notification = [
            'title' => $this->eProvider->name,
            'body' => trans('lang.notification_e_provider_payout_paid', ['e_provider_payout_id' => $this->eProviderPayout->id, 'user_name' => $this->eProvider->name]),
            'icon' => $this->getEServiceMediaUrl(),
            'click_action' => "FLUTTER_NOTIFICATION_CLICK",
            'id' => 'App\Notifications\EProviderPayoutPaid',
            'status' => 'done',
        ];
        $data = $notification;
        $data['e_provider_payout_id'] = $this->eProviderPayout->id;
        $message->content($notification)->data($data)->priority(FcmMessage::PRIORITY_HIGH);

        return $message;
    }

    private function getEServiceMediaUrl(): string
    {
        if ($this->eProvider->hasMedia('image')) {
            return $this->eProvider->getFirstMediaUrl('image', 'thumb');
        } else {
            return asset('images/image_default.png');
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable): array
    {
        return [
            'e_provider_payout_id' => $this->eProviderPayout['id'],
        ];
    }
}
