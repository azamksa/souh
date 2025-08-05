<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\Admin\TripController as AdminTripController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Routes للرحلات - متاحة للجميع لعرض القائمة
Route::get('/trips', [TripController::class, 'index'])->name('trips.index');

// تفاصيل الرحلة - تحتاج تسجيل دخول
Route::get('/trips/{trip}', [TripController::class, 'show'])
    ->middleware('auth')
    ->name('trips.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/welcome', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // طلبات الرحلات
    Route::get('/requests', [RequestController::class, 'index'])->name('requests.index');
    Route::get('/requests/create/{trip}', [RequestController::class, 'create'])->name('requests.create');
    Route::post('/requests', [RequestController::class, 'store'])->name('requests.store');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('trips', AdminTripController::class);
});

require __DIR__.'/auth.php';
