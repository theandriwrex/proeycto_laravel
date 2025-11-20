<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/prime/{prime}', function ($prime) {
    return ('Prime number: ' . $prime);
});