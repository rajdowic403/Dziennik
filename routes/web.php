<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/api/events', [EventController::class, 'index']);
    Route::post('/api/events', [EventController::class, 'store']);
    Route::get('/moderator/dashboard', [DashboardController::class, 'moderatorIndex'])->name('moderator.dashboard');
    Route::get('/student/dashboard', [DashboardController::class, 'studentIndex'])->name('student.dashboard');
});

Route::middleware(['auth', 'role:moderator'])->group(function () {
    Route::get('/admin/schedule', [ScheduleController::class, 'index'])->name('admin.schedule');
    Route::post('/admin/lessons', [ScheduleController::class, 'store']);
});

require __DIR__.'/auth.php';
