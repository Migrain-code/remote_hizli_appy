<?php

namespace App\Services;
use App\Models\SendedSms;
class Sms
{
    private static string $apiUrl = "https://api.netgsm.com.tr/bulkhttppost.asp";
    const username = '4646060976';
    const password = 'V3.7CHR5';
    const title = 'Hizlirandvu';

    public static function send($number, $message)
    {
        $sms = new SendedSms();
        $sms->phone = $number;
        $sms->message = $message;
        $sms->save();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => self::$apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('usercode' => self::username,
                'password' => self::password,
                'gsmno' => $number,
                'message' => $message,
                'msgheader' => self::title,
                'filter' => '0',
                'startdate' => '',
                'stopdate' => '',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

    }

}
