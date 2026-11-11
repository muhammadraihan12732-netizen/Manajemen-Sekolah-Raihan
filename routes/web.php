<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
});

Route::middleware('auth')->group(function () {
    Route::get('/', fn () => redirect()->route('dashboard'));
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::resource('students', StudentController::class);
    Route::resource('classes', ClassController::class)->except('show')->parameters(['classes' => 'schoolClass']);
    Route::resource('majors', MajorController::class)->except('show');

    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/print', [ReportController::class, 'print'])->name('print');
        Route::get('/excel', [ReportController::class, 'excel'])->name('excel');
        Route::get('/pdf', [ReportController::class, 'pdf'])->name('pdf');
    });

    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings/profile', [SettingController::class, 'updateProfile'])->name('settings.profile');
    Route::put('/settings/password', [SettingController::class, 'updatePassword'])->name('settings.password');
});
