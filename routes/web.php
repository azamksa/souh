<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\Admin\TripController as AdminTripController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ReportsController as AdminReportsController;
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
    
    // نظام التقييمات
    Route::post('/ratings', [RatingController::class, 'store'])->name('ratings.store');
    Route::get('/ratings/{trip}', [RatingController::class, 'show'])->name('ratings.show');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // لوحة التحكم الرئيسية
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // إدارة الرحلات
    Route::resource('trips', AdminTripController::class);
    
    // إدارة الطلبات
    Route::get('/requests', [AdminDashboardController::class, 'requests'])->name('requests.index');
    Route::patch('/requests/{request}/status', [AdminDashboardController::class, 'updateRequestStatus'])->name('requests.updateStatus');
    
    // إدارة التقييمات
    Route::get('/ratings', [AdminDashboardController::class, 'ratings'])->name('ratings.index');
    Route::delete('/ratings/{rating}', [RatingController::class, 'destroy'])->name('ratings.destroy');
    
    // إدارة المستخدمين
    Route::get('/users', [AdminDashboardController::class, 'users'])->name('users.index');
    Route::patch('/users/{user}/toggle-status', [AdminDashboardController::class, 'toggleUserStatus'])->name('users.toggleStatus');
    
    // تقارير وإحصائيات - الراوت الجديد
    Route::get('/reports', [AdminReportsController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [AdminReportsController::class, 'exportData'])->name('reports.export');
    
    // الإعدادات
    Route::get('/settings', function() {
        return view('admin.settings.index');
    })->name('settings.index');
});

require __DIR__.'/auth.php';