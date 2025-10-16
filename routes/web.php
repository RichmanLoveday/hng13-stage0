<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


//? code to run migration since i am using PXXL App
Route::get('/migrate-now', function () {
    Artisan::call('migrate', ['--force' => true]);
    return "Migration completed!";
});
