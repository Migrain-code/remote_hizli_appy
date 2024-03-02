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

function sendNotification($title, $message, $link = null){
    $oneSignalService = new \App\Services\OneSignalNotification();
    $result = $oneSignalService->sendNotification('Test Başlık', 'Test Mesaj');

    return $result;
}