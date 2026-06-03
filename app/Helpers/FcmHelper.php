<?php
/*
 * FCM Push Notification Helper
 * Sends Firebase Cloud Messaging notifications using the legacy HTTP API.
 */

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class FcmHelper
{
    /**
     * Send a push notification to a single device token.
     *
     * @param string $deviceToken The FCM device token
     * @param string $title Notification title
     * @param string $body Notification body
     * @param array $data Additional data payload
     * @return bool
     */
    public static function sendToDevice(string $deviceToken, string $title, string $body, array $data = []): bool
    {
        if (empty($deviceToken)) {
            return false;
        }

        $serverKey = setting('fcm_key', config('services.fcm.server_key', ''));
        if (empty($serverKey)) {
            Log::warning('FCM server key not configured. Cannot send push notification.');
            return false;
        }

        $payload = [
            'to' => $deviceToken,
            'notification' => [
                'title' => $title,
                'body' => $body,
                'sound' => 'default',
                'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
            ],
            'data' => array_merge([
                'title' => $title,
                'body' => $body,
                'icon' => '',
                'image' => '',
            ], $data),
        ];

        return self::sendToFcm($payload, $serverKey);
    }

    /**
     * Send a push notification to multiple device tokens.
     *
     * @param array $deviceTokens Array of FCM device tokens
     * @param string $title
     * @param string $body
     * @param array $data
     * @return int Number of successful sends
     */
    public static function sendToDevices(array $deviceTokens, string $title, string $body, array $data = []): int
    {
        $deviceTokens = array_filter($deviceTokens); // Remove empty tokens
        if (empty($deviceTokens)) {
            return 0;
        }

        $serverKey = setting('fcm_key', config('services.fcm.server_key', ''));
        if (empty($serverKey)) {
            Log::warning('FCM server key not configured. Cannot send push notifications.');
            return 0;
        }

        // FCM supports max 1000 tokens per request
        $chunks = array_chunk($deviceTokens, 1000);
        $successCount = 0;

        foreach ($chunks as $chunk) {
            $payload = [
                'registration_ids' => array_values($chunk),
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                    'sound' => 'default',
                    'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                ],
                'data' => array_merge([
                    'title' => $title,
                    'body' => $body,
                    'icon' => '',
                    'image' => '',
                ], $data),
            ];

            if (self::sendToFcm($payload, $serverKey)) {
                $successCount += count($chunk);
            }
        }

        return $successCount;
    }

    /**
     * Send payload to FCM.
     *
     * @param array $payload
     * @param string $serverKey
     * @return bool
     */
    private static function sendToFcm(array $payload, string $serverKey): bool
    {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: key=' . $serverKey,
                'Content-Type: application/json',
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200) {
                Log::info('FCM push sent successfully', ['response' => $response]);
                return true;
            }

            Log::error('FCM push failed', ['http_code' => $httpCode, 'response' => $response]);
            return false;
        } catch (\Exception $e) {
            Log::error('FCM push exception: ' . $e->getMessage());
            return false;
        }
    }
}
