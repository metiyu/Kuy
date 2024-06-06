<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\PlayTogetherController;

Route::get('/', function () {
    return view('index');
});

Route::get('/venues', [VenueController::class, 'index'])->name('venues');

Route::get('/venue/{id}', [VenueController::class, 'show'])->name('venue');

Route::get('/play-togethers', [PlayTogetherController::class, 'index'])->name('play-togethers');

Route::get('/test', function () {
    return view('test');
});

