<?php

namespace App\Services;
use GuzzleHttp\Client;

class NotificationService
{
    public static function sendPushNotification($expoToken, $title, $body, $link = null)
    {
        $client = new Client();
        $response = $client->post(env('EXPO_PUSH_URL'), [
            'json' => [
                'to' => $expoToken,
                'title' => $title,
                'body' => $body,
                'data' => [
                    "link" => isset($link) ? $link : null,
                ],
                'sound'=> 'default',
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
