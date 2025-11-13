<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HallController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HallAvailabilitiesController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

/**
 * Hall Routes
 */
Route::get('/halls', [HallController::class, 'index'])->name('halls.index');
Route::get('/halls/create', [HallController::class, 'create'])->name('halls.create');
Route::post('/halls', [HallController::class, 'store'])->name('halls.store');
Route::get('/halls/{hall}/edit', [HallController::class, 'edit'])->name('halls.edit');
Route::put('/halls/{hall}', [HallController::class, 'update'])->name('halls.update');
Route::delete('/halls/{hall}', [HallController::class, 'destroy'])->name('halls.destroy');

/**
 * Service Routes
 */
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
Route::get('/services/{id}/edit', [ServiceController::class, 'edit'])->name('services.edit');
Route::put('/services/{id}', [ServiceController::class, 'update'])->name('services.update');
Route::delete('/services/{id}', [ServiceController::class, 'destroy'])->name('services.destroy');

/**
 * Reservation Routes
 */
Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
Route::get('/reservations/{id}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
Route::get('/reservations/{id}/', [ReservationController::class, 'show'])->name('reservations.show');
Route::put('/reservations/{id}', [ReservationController::class, 'update'])->name('reservations.update');
Route::delete('/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
Route::put('/reservations/{id}/konfirmasi', [ReservationController::class, 'konfirmasi'])
     ->name('reservations.konfirmasi');


Route::post('/admin/cleanup-old-data', [ReservationController::class, 'cleanupOldData'])->name('admin.cleanup.olddata');
/**
 * Finance Routes
 */
Route::get('/finances', [FinanceController::class, 'index'])->name('finances.index');
Route::get('/finances/create', [FinanceController::class, 'create'])->name('finances.create');
Route::post('/finances', [FinanceController::class, 'store'])->name('finances.store');
Route::get('/finances/{id}/edit', [FinanceController::class, 'edit'])->name('finances.edit');
Route::put('/finances/{id}', [FinanceController::class, 'update'])->name('finances.update');
Route::get('/finances/pdf', [FinanceController::class, 'exportPdf'])->name('finances.pdf');
Route::delete('/finances/delete-old', [FinanceController::class, 'deleteOld'])->name('finances.deleteOld');



/**
 * Calendar Routes
 */
Route::get('/calendar', [HallAvailabilitiesController::class, 'index'])->name('calendar.index');
Route::get('/calendars', [HallAvailabilitiesController::class, 'indexx'])->name('calendars.indexx');
Route::get('/calendar/create', [HallAvailabilitiesController::class, 'create'])->name('calendar.create');
Route::post('/calendar', [HallAvailabilitiesController::class, 'store'])->name('calendar.store');
Route::get('/calendar/{id}/edit', [HallAvailabilitiesController::class, 'edit'])->name('calendar.edit');
Route::put('/calendar/{id}', [HallAvailabilitiesController::class, 'update'])->name('calendar.update');
Route::delete('/calendar/{calendar}', [HallAvailabilitiesController::class, 'destroy'])->name('calendar.destroy');

// web.php


Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
Route::get('/payments/{payment}/edit', [PaymentController::class, 'edit'])->name('payments.edit');
Route::put('/payments/{payment}', [PaymentController::class, 'update'])->name('payments.update');
Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])->name('payments.destroy');
Route::get('/payments/{payment}/receipt', [PaymentController::class, 'receipt'])->name('payments.receipt');
Route::put('/payments/{payment}/konfirmasi', [PaymentController::class, 'konfirmasi'])
     ->name('payments.konfirmasi');

});


require __DIR__.'/auth.php';
