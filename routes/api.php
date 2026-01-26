<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Subject;
use App\Models\ClassGroup;


Route::get('/teachers', fn() => User::role('teacher')->get(['id', 'name']));
Route::get('/subjects', fn() => Subject::all(['id', 'name']));
Route::get('/groups', fn() => ClassGroup::all(['id', 'name']));
Route::post('/lessons', [App\Http\Controllers\Api\LessonController::class, 'store']);
Route::get('/lessons', [App\Http\Controllers\Api\LessonController::class, 'index']);