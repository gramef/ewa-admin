<?php
/*
 * Admin Push Notification Controller
 * Allows admin to compose and send push notifications to all users,
 * specific users, or user groups (clients/vendors).
 */

namespace App\Http\Controllers\Admin;

use App\Helpers\FcmHelper;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Exception;
use Flash;
use Illuminate\Http\Request;

class PushNotificationController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Show the "Compose Push Notification" form.
     */
    public function create()
    {
        $userCount = User::whereNotNull('device_token')->where('device_token', '!=', '')->count();
        $clientCount = User::role('default')->whereNotNull('device_token')->where('device_token', '!=', '')->count();
        $vendorCount = User::role('provider')->whereNotNull('device_token')->where('device_token', '!=', '')->count();
        $users = User::pluck('name', 'id');

        return view('admin.push_notifications.create', compact('userCount', 'clientCount', 'vendorCount', 'users'));
    }

    /**
     * Send the push notification.
     */
    public function send(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'body' => 'required|string|max:1000',
            'target' => 'required|in:all,clients,vendors,specific',
            'user_id' => 'nullable|integer|exists:users,id',
        ]);

        $title = $request->input('title');
        $body = $request->input('body');
        $target = $request->input('target');
        $sentCount = 0;

        try {
            switch ($target) {
                case 'all':
                    $tokens = User::whereNotNull('device_token')
                        ->where('device_token', '!=', '')
                        ->pluck('device_token')
                        ->toArray();
                    $sentCount = FcmHelper::sendToDevices($tokens, $title, $body);
                    // Create a notification record for all users
                    $users = User::whereNotNull('device_token')->where('device_token', '!=', '')->get();
                    foreach ($users as $user) {
                        Notification::create([
                            'title' => $title,
                            'body' => $body,
                            'user_id' => $user->id,
                            'type' => 'push',
                        ]);
                    }
                    break;

                case 'clients':
                    $tokens = User::role('default')
                        ->whereNotNull('device_token')
                        ->where('device_token', '!=', '')
                        ->pluck('device_token')
                        ->toArray();
                    $sentCount = FcmHelper::sendToDevices($tokens, $title, $body);
                    $users = User::role('default')->whereNotNull('device_token')->where('device_token', '!=', '')->get();
                    foreach ($users as $user) {
                        Notification::create([
                            'title' => $title,
                            'body' => $body,
                            'user_id' => $user->id,
                            'type' => 'push',
                        ]);
                    }
                    break;

                case 'vendors':
                    $tokens = User::role('provider')
                        ->whereNotNull('device_token')
                        ->where('device_token', '!=', '')
                        ->pluck('device_token')
                        ->toArray();
                    $sentCount = FcmHelper::sendToDevices($tokens, $title, $body);
                    $users = User::role('provider')->whereNotNull('device_token')->where('device_token', '!=', '')->get();
                    foreach ($users as $user) {
                        Notification::create([
                            'title' => $title,
                            'body' => $body,
                            'user_id' => $user->id,
                            'type' => 'push',
                        ]);
                    }
                    break;

                case 'specific':
                    $userId = $request->input('user_id');
                    $user = User::find($userId);
                    if ($user && $user->device_token) {
                        $sent = FcmHelper::sendToDevice($user->device_token, $title, $body);
                        $sentCount = $sent ? 1 : 0;
                        Notification::create([
                            'title' => $title,
                            'body' => $body,
                            'user_id' => $user->id,
                            'type' => 'push',
                        ]);
                    } else {
                        Flash::warning('User does not have a registered device. Notification saved but push not sent.');
                        Notification::create([
                            'title' => $title,
                            'body' => $body,
                            'user_id' => $userId,
                            'type' => 'push',
                        ]);
                        return redirect()->back();
                    }
                    break;
            }

            Flash::success("Push notification sent successfully to {$sentCount} device(s).");
        } catch (Exception $e) {
            Flash::error('Error sending push notification: ' . $e->getMessage());
        }

        return redirect()->route('admin.push.create');
    }

    /**
     * Show push notification history.
     */
    public function history()
    {
        $notifications = Notification::where('type', 'push')
            ->orderByDesc('created_at')
            ->groupBy('title', 'body', 'created_at')
            ->limit(50)
            ->get();

        return view('admin.push_notifications.history', compact('notifications'));
    }
}
