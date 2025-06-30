<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayersController;
use App\Http\Controllers\AuthController;

// Authentication routes
// 認証関連ルート
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [App\Http\Controllers\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\RegisterController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Player management routes
// 選手関連ルート
Route::get('/', [PlayersController::class, 'index'])->name('players.index');
Route::get('/detail/{id}', [PlayersController::class, 'detail'])->name('players.detail');
// Ensure only the player ID is passed in the URL and no sensitive data is exposed
Route::get('/edit/{id}', [PlayersController::class, 'edit'])->name('players.edit');
Route::put('/update/{id}', [PlayersController::class, 'update'])->name('players.update');
Route::delete('/delete/{id}', [PlayersController::class, 'destroy'])->name('players.destroy');