<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\PlayTogetherController;

Route::get('/', function () {
    return view('index');
});

Route::get('/venues', [VenueController::class, 'index'])->name('venues');

Route::get('/venue/{id}', [VenueController::class, 'show'])->name('venue');

Route::get('/main-bareng', [PlayTogetherController::class, 'index'])->name('main-bareng');

Route::get('/main-bareng/{id}', [PlayTogetherController::class, 'show'])->name('main-bareng');

Route::get('/daftarkan-venue', [VenueController::class, 'create'])->name('daftarkan-venue');

Route::post('/simpan-venue', [VenueController::class, 'store'])->name('simpan-venue');

Route::get('/test', function () {
    return view('test');
});

