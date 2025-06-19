<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayersController;

Route::get('/', [PlayersController::class, 'index']);
Route::get('/detail/{id}', [PlayersController::class, 'detail'])->name('players.detail');
Route::get('/edit/{id}', [PlayersController::class, 'edit'])->name('players.edit');
Route::put('/update/{id}', [PlayersController::class, 'update'])->name('players.update');
Route::delete('/delete/{id}', [PlayersController::class, 'destroy'])->name('players.destroy');