<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FirebaseService
{
    protected $messaging;

    public function __construct()
    {
        $serviceAccountPath = config('firebase.credentials.file');

        if (is_null($serviceAccountPath)) {
            throw new \InvalidArgumentException('Firebase credentials file not found.');
        }

        $this->messaging = (new Factory())
            ->withServiceAccount($serviceAccountPath)
            ->createMessaging();
    }

    public function sendPushNotification($token, $title, $body)
    {
        \Log::info('Sending push notification with token: ' . $token);

        if (empty($token)) {
            throw new \InvalidArgumentException('Firebase token is missing or invalid.');
        }

        $notification = Notification::create($title, $body);

        $message = CloudMessage::withTarget('token', $token)
            ->withNotification($notification);

        try {
            $this->messaging->send($message);
            \Log::info('Notification sent successfully.');
        } catch (\Exception $e) {
            \Log::error('Failed to send notification: ' . $e->getMessage());
        }
    }
}
