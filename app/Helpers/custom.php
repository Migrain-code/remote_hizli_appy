<?php

function storage($path): string
{
    return asset('storage/' . $path);
}
function image($path)
{
    return env('IMAGE_URL').$path;
}
function setting($key){
    return config('settings.'.$key);
}

function authUser(){
    if (auth('official')->check()){
        return auth('official')->user();
    }
    elseif (auth('admin')->check()){
        return auth('admin')->user();
    }
    else{
        /*personel olarak değişecek*/
        return auth('admin')->user();
    }
}
function clearPhone($phoneNumber){
    $newPhoneNumber = str_replace([' ', '(', ')', '-'], '', $phoneNumber);

    return $newPhoneNumber;

}
function maskPhone($phone){
    $phone = clearPhone($phone);
    $phoneLength = strlen($phone);

    if ($phoneLength > 4) {
        $maskedPhone = str_repeat('*', $phoneLength - 4) . substr($phone, -4);
        return $maskedPhone;
    }

    return $phone;
}
function calculateTotal($services)
{
    $total = 0;
    foreach ($services as $service) {
        if ($service->service) {
            $total += $service->service->price;
        }
    }
    return $total;
}
function formatPrice($price)
{
    return number_format($price, 2) . ' ₺';
}
function formatNoIconPrice($price)
{
    return number_format($price, 2);
}
