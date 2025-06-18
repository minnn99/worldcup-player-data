<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayersController;

Route::get('/', [PlayersController::class, 'index']);
Route::get('/detail/{id}', [PlayersController::class, 'detail'])->name('players.detail');