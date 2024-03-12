<?php

use Illuminate\Support\Facades\Route;

Route::controller(\App\Http\Controllers\HomeController::class)->group(function (){
    Route::get('language/{locale}', 'language')->name('language');
    Route::get('/', 'index')->name('welcome');
    Route::get('imsakiye', 'imsakiye');
});