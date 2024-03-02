<?php

namespace App\Services;
use onesignal\client\api\DefaultApi;
use onesignal\client\Configuration;
use onesignal\client\model\Notification;
use onesignal\client\model\StringMap;
use GuzzleHttp\Client;
class OneSignalNotification
{
    protected $appId;
    protected $appKeyToken;
    protected $userKeyToken;
    protected $apiInstance;

    public function __construct()
    {
        $this->appId = env('ONESIGNAL_APP_ID');
        $this->appKeyToken = env('ONESIGNAL_API_KEY');
        //$this->userKeyToken = env('ONESIGNAL_USER_KEY_TOKEN');

        $config = Configuration::getDefaultConfiguration()
            ->setAppKeyToken($this->appKeyToken)
            ->setUserKeyToken($this->userKeyToken);

        $this->apiInstance = new DefaultApi(new Client(), $config);
    }

    public function createNotification($enContent): Notification
    {
        $content = new StringMap();
        $content->setEn($enContent);

        $notification = new Notification();
        $notification->setAppId($this->appId);
        $notification->setContents($content);
        $notification->setIncludedSegments(['Subscribed Users']);

        return $notification;
    }

    public function sendNotification($notification)
    {
        $result = $this->apiInstance->createNotification($notification);
        return $result;
    }

    public function sendUserNotification($enContent)
    {
        $notification = $this->createNotification($enContent);
        $result = $this->sendNotification($notification);

        return $result;
    }

}