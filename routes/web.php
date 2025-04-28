<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Web Routes
Route::view('/', view: 'welcome')->name('welcome');
Route::view('/register', 'register')->name('regform');
Route::view('/dashboard', 'dashboard')->name('dashboard')->middleware('auth');


// Authentication Routes
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
