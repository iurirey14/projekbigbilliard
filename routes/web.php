<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BilliardTableController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Auth Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('guest');

Route::get('/register', function () {
    return view('auth.register');
})->name('register')->middleware('guest');

Route::post('/register', [AuthController::class, 'register'])->name('register.post')->middleware('guest');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    // Billiard Tables Routes
    Route::get('/tables', [BilliardTableController::class, 'index'])->name('tables.index');
    Route::get('/tables/{id}', [BilliardTableController::class, 'show'])->name('tables.show');
    Route::get('/api/available-tables', [BilliardTableController::class, 'getAvailableTables'])->name('api.available-tables');

    // Booking Routes
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{id}', [BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{id}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');

    // Payment Routes
    Route::get('/payments/{bookingId}', [PaymentController::class, 'show'])->name('payments.show');
    Route::post('/payments/{bookingId}/process', [PaymentController::class, 'process'])->name('payments.process');
    Route::get('/payments', [PaymentController::class, 'list'])->name('payments.list');
    Route::get('/payments/{bookingId}/receipt', [PaymentController::class, 'receipt'])->name('payments.receipt');
});

