<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrekwencjaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Trasy dla zalogowanych
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/api/events', [EventController::class, 'index']);
    Route::post('/api/events', [EventController::class, 'store']);
    
    Route::get('/student/dashboard', [DashboardController::class, 'studentIndex'])->name('student.dashboard');
    Route::get('/teacher/dashboard', [DashboardController::class, 'teacherIndex'])->name('teacher.dashboard');
});

// Trasy dla nauczycieli i adminów
Route::middleware(['auth', 'role:teacher|admin'])->group(function () {

    Route::get('/lessons/{lesson}/frekwencja', [FrekwencjaController::class, 'create'])->name('frekwencja.create');
    Route::post('/lessons/{lesson}/frekwencja', [FrekwencjaController::class, 'store'])->name('frekwencja.store');

    });

// Trasy dla adminów
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/dashboard', [DashboardController::class, 'adminIndex'])->name('admin.dashboard');
    Route::post('/admin/lessons', [ScheduleController::class, 'store']);

});

require __DIR__.'/auth.php';