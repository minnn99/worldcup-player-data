<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayersController;
use App\Http\Controllers\AuthController;

// 인증 관련 라우트
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 인증이 필요한 라우트 그룹
Route::middleware(['check.auth'])->group(function () {
    // 선수 목록 (인증된 사용자만 접근 가능)
    Route::get('/', [PlayersController::class, 'index'])->name('players.index');
    Route::get('/detail/{id}', [PlayersController::class, 'detail'])->name('players.detail');
});

// 관리자만 접근 가능한 라우트
Route::middleware(['check.auth', 'check.admin'])->group(function () {
    Route::get('/players/{id}/edit', [PlayersController::class, 'edit'])->name('players.edit');
    Route::put('/players/{id}', [PlayersController::class, 'update'])->name('players.update');
    Route::delete('/players/{id}', [PlayersController::class, 'destroy'])->name('players.destroy');
    Route::get('/players/create', [PlayersController::class, 'create'])->name('players.create');
    Route::post('/players', [PlayersController::class, 'store'])->name('players.store');
});
