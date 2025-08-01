<?php

use App\Http\Controllers\TripController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\Admin\TripController as AdminTripController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TripController::class, 'index'])->name('trips.index');
Route::get('/trips/{trip}', [TripController::class, 'show'])->name('trips.show');

Route::middleware(['auth'])->group(function () {
    Route::resource('requests', RequestController::class)->only(['create', 'store', 'index']);
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('admin/trips', AdminTripController::class);
});