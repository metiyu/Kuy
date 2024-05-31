<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/venues', function () {
    return view('venues');
});

Route::get('/venue/{name}', function () {
    return view('venue-detail');
});

Route::get('/test', function () {
    return view('test');
});

