<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayersController;
use App\Http\Controllers\AuthController;

// 認証関連のルート
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [App\Http\Controllers\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\RegisterController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 選手管理のルート
Route::get('/', [PlayersController::class, 'index'])->name('players.index');
Route::get('/detail/{id}', [PlayersController::class, 'detail'])->name('players.detail');
// URLには選手IDのみを渡し、機密情報は公開しないようにする
Route::get('/edit/{id}', [PlayersController::class, 'edit'])->name('players.edit');
Route::put('/update/{id}', [PlayersController::class, 'update'])->name('players.update');
Route::delete('/delete/{id}', [PlayersController::class, 'destroy'])->name('players.destroy');