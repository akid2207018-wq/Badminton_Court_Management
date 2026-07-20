<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CourtController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DebugController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::get('/', [CourtController::class, 'index'])->name('home');
Route::get('/courts', [CourtController::class, 'index'])->name('courts.index');
Route::get('/courts/{court}', [CourtController::class, 'show'])->name('courts.show');

Route::middleware('auth')->group(function () {

    // Debug: Cookies & Sessions demo
    Route::get('/debug/cookies-sessions', [DebugController::class, 'show'])->name('debug.cookies-sessions');
    Route::post('/debug/reset-session', [DebugController::class, 'resetSession'])->name('debug.session.reset');
    Route::post('/debug/clear-cookie', [DebugController::class, 'clearCookie'])->name('debug.cookie.clear');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Bookings
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])
        ->middleware(['booking.double', 'court.open'])
        ->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])
        ->middleware('booking.owner')
        ->name('bookings.show');
    Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])
        ->middleware('booking.owner')
        ->name('bookings.cancel');
    Route::patch('/bookings/{booking}/confirm', [BookingController::class, 'confirm'])
        ->middleware('booking.owner')
        ->name('bookings.confirm');

    // AJAX: get available time slots
    Route::get('/api/slots', [BookingController::class, 'getSlots'])->name('api.slots');

    // Payments
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/create/{booking}', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
});
