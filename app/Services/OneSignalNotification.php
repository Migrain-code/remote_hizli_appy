<?php

namespace App\Services;
use onesignal\client\api\DefaultApi;
use onesignal\client\Configuration;
use onesignal\client\model\Notification;
use onesignal\client\model\StringMap;
use GuzzleHttp\Client;
class OneSignalNotification
{
    private $app_id;
    private $api_key;
    private $apiUrl = "https://onesignal.com/api/v1/notifications";
    public function __construct() {
        $this->app_id = env('ONESIGNAL_APP_ID');
        $this->api_key = env('ONESIGNAL_API_KEY');
    }

    public function sendNotification($title, $message) {
        $data = array(
            "app_id" => $this->app_id,
            "contents" => array("en" => $message),
            "headings" => array("en" => $title),
            "included_segments" => array("All")
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic ' . $this->api_key
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        if ($response === FALSE) {
            throw new \Exception('Curl failed: ' . curl_error($ch));
        }

        $responseData = json_decode($response, true);

        if (isset($responseData['errors'])) {
            throw new \Exception("Bir hata oluştu: " . implode(", ", $responseData['errors']));
        } else {
            return "Bildirim başarıyla gönderildi.";
        }
    }

}