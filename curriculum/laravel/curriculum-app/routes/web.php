<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayersController;

// ホームページルート（選手リスト）
Route::get('/', [PlayersController::class, 'index'])->name('players.index');

// 選手関連ルート
Route::get('/detail/{id}', [PlayersController::class, 'show'])->name('players.detail'); // URLを /detail/{id} に変更
Route::get('/players/{id}/edit', [PlayersController::class, 'edit'])->name('players.edit');
Route::put('/players/{id}', [PlayersController::class, 'update'])->name('players.update');
Route::delete('/players/{id}', [PlayersController::class, 'destroy'])->name('players.destroy');
Route::get('/players/create', [PlayersController::class, 'create'])->name('players.create');
Route::post('/players', [PlayersController::class, 'store'])->name('players.store');

// セッションリセットルート
Route::post('/reset-player-session', function() {
  session(['can_access_player_detail' => true]);
  return response()->json(['success' => true]);
});