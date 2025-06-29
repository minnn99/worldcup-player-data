<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayersController;
use App\Http\Controllers\AuthController;

// 認証関連のルート
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 選手関連のルート
Route::get('/', [PlayersController::class, 'index'])->name('players.index');
Route::get('/detail/{id}', [PlayersController::class, 'detail'])->name('players.detail');
Route::get('/edit/{id}', [PlayersController::class, 'edit'])->name('players.edit');
Route::put('/update/{id}', [PlayersController::class, 'update'])->name('players.update');
Route::delete('/delete/{id}', [PlayersController::class, 'destroy'])->name('players.destroy');