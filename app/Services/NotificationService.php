<?php

namespace App\Services;
use GuzzleHttp\Client;

class NotificationService
{
    public static function sendPushNotification($expoToken, $title, $body)
    {
        $client = new Client();
        $response = $client->post(env('EXPO_PUSH_URL'), [
            'json' => [
                'to' => $expoToken,
                'title' => $title,
                'body' => $body,
                'sound'=> 'default',
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
