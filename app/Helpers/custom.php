<?php

function storage($path): string
{
    return asset('storage/' . $path);
}
function image($path){
    return env('REMOTE_URL').'/storage/'.$path;
}
function setting($key){
    return config('settings.'.$key);
}
function authUser(){
    if (auth('business')->check()){
        return auth('business')->user();
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