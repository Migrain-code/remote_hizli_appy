<?php

namespace App\Services;
use OneSignal\OneSignal;
use Illuminate\Support\Facades\Config;
use GuzzleHttp\Client;

class OneSignalNotification
{
    protected $oneSignal;

    public function __construct()
    {
        $this->oneSignal = new OneSignal(
            env('ONESIGNAL_APP_ID'),
            env('ONESIGNAL_REST_API_KEY')
        );
    }

    public function sendNotification($userId, $message, $url = null)
    {
        $params = [
            'contents' => ['en' => $message],
            'include_player_ids' => [$userId],
        ];

        if ($url) {
            $params['url'] = $url;
        }

        $this->oneSignal->notifications->add($params);
    }
}