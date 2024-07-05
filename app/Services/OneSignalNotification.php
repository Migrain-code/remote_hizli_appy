<?php

namespace App\Services;
use DateTime;
use onesignal\client\api\DefaultApi;
use onesignal\client\Configuration;
use onesignal\client\model\GetNotificationRequestBody;
use onesignal\client\model\Notification;
use onesignal\client\model\StringMap;
use onesignal\client\model\Player;
use onesignal\client\model\UpdatePlayerTagsRequestBody;
use onesignal\client\model\ExportPlayersRequestBody;
use onesignal\client\model\Segment;
use onesignal\client\model\FilterExpressions;
use PHPUnit\Framework\TestCase;
use GuzzleHttp;

class OneSignalNotification
{
    protected $oneSignal;
    protected $APP_ID = "";
    protected $APP_KEY_TOKEN = "";
    protected $USER_KEY_TOKEN = "";

    protected $apiInstance = "";

    public function __construct()
    {
        $this->APP_ID = env('ONESIGNAL_APP_ID');
        $this->APP_KEY_TOKEN = env('ONESIGNAL_REST_API_KEY');
        $this->USER_KEY_TOKEN = env('ONESIGNAL_AUTH_KEY');

        $config = Configuration::getDefaultConfiguration()
            ->setAppKeyToken($this->APP_KEY_TOKEN)
            ->setUserKeyToken($this->USER_KEY_TOKEN);

        $guzzleConfig = [
            'verify' => false, // SSL sertifikası doğrulamasını devre dışı bırak
            // Diğer GuzzleHttp istemci yapılandırma seçenekleri
        ];
        $this->apiInstance = new DefaultApi(
            new GuzzleHttp\Client($guzzleConfig),
            $config
        );
    }

    function createNotification($enContent): Notification { // belirli bir kullanıcı grubuna gönderme
        $content = new StringMap();
        $content->setEn($enContent);

        $notification = new Notification();
        $notification->setAppId($this->APP_ID);
        $notification->setContents($content);
        $notification->setIncludedSegments(['Subscribed Users']);

        return $notification;
    }
    public function sendNotificationToUser($playerId, $message) // tek kullanıcıya gönderme
    {
        $content = new StringMap();
        $content->setEn($message);

        $notification = new Notification();
        $notification->setAppId($this->APP_ID);
        $notification->setContents($content);
        $notification->setIncludePlayerIds([$playerId]); // Belirli bir kullanıcıya göndermek için Player ID belirtin

        $result = $this->apiInstance->createNotification($notification);
        return $result;
    }

}