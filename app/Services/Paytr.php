<?php

namespace App\Services;

class Paytr
{
    protected $merchantId;
    protected $merchantKey;
    protected $merchantSalt;
    protected $postUrl = "https://www.paytr.com/odeme";
    // Diğer gerekli özellikleri ekleyebilirsiniz

    public function __construct($merchantId, $merchantKey, $merchantSalt, $postUrl)
    {
        $this->merchantId = $merchantId;
        $this->merchantKey = $merchantKey;
        $this->merchantSalt = $merchantSalt;
        $this->postUrl = $postUrl;
        // Diğer gerekli özellikleri buraya ekleyin
    }

    public function initiatePayment($userData, $request)
    {
        $client = new \GuzzleHttp\Client();

        $response = $client->post($this->postUrl, [
            'form_params' => [
                'merchant_id' => $this->merchantId,
                'merchant_key' => $this->merchantKey,
                'cc_owner' => $userData->name,
                'card_number' => $request->card_number,
                ''
            ],
        ]);

        // API'den gelen yanıtı kontrol etme ve gerekli işlemleri yapma

        // Örnek: $result = json_decode($response->getBody(), true);
        // ...
    }

}
