<?php

use App\Http\Controllers\CartDetailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\PlayTogetherController;
use App\Http\Controllers\PlayTogetherDetailController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthenticateMiddleware;
use App\Models\Transaction;

Route::get('/', function () {
    return view('index');
});

Route::post('/daftar', [UserController::class, 'signUp'])->name('daftar');

Route::post('/masuk', [UserController::class, 'signIn'])->name('masuk');

Route::post('/keluar', [UserController::class, 'logout'])->name('keluar')->middleware(AuthenticateMiddleware::class);

Route::get('/venues', [VenueController::class, 'index'])->name('venues');

Route::get('/venue/{id}', [VenueController::class, 'show'])->name('venue');

Route::get('/main-bareng', [PlayTogetherController::class, 'index'])->name('main-bareng');

Route::get('/main-bareng-detail/{id}', [PlayTogetherController::class, 'show'])->name('main-bareng-detail');

Route::post('/remove-player', [PlayTogetherDetailController::class,'destroy'])->name('remove-player')->middleware(AuthenticateMiddleware::class);

Route::get('/daftarkan-venue', [VenueController::class, 'create'])->name('daftarkan-venue')->middleware(AuthenticateMiddleware::class);

Route::post('/simpan-venue', [VenueController::class, 'store'])->name('simpan-venue')->middleware(AuthenticateMiddleware::class);

Route::get('/get-transactions', [TransactionController::class,'getTransactions'])->name('getTransactions')->middleware(AuthenticateMiddleware::class);

Route::get('/daftarkan-main-bareng', [PlayTogetherController::class, 'create'])->name('daftarkan-main-bareng')->middleware(AuthenticateMiddleware::class);

Route::post('/simpan-main-bareng', [PlayTogetherController::class, 'store'])->name('simpan-main-bareng')->middleware(AuthenticateMiddleware::class);

Route::post('/ikut-main-bareng', [PlayTogetherDetailController::class,'store'])->name('ikut-main-bareng')->middleware(AuthenticateMiddleware::class);

Route::post('/manage-cart', [CartDetailController::class, 'store'])->name('manage-cart')->middleware(AuthenticateMiddleware::class);

Route::post('/review-checkout', [TransactionController::class, 'create'])->name('review-checkout')->middleware(AuthenticateMiddleware::class);

Route::post('/checkout', [TransactionController::class,'store'])->name('checkout')->middleware(AuthenticateMiddleware::class);

Route::get('/transaksi', [TransactionController::class, 'index'])->name('transaksi')->middleware(AuthenticateMiddleware::class);

Route::get('/test', function () {
    return view('test');
});

