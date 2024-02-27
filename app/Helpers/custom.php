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
function base64Convertor($base64){

    $newProfile = "data:image/jpeg;base64,".$base64;
    $data = explode(',', $newProfile);
    $image = base64_decode($data[1]);

    return $image;
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