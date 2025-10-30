<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;

Route::get('/game', [GameController::class, 'intro'])->name('game.start');
Route::post('/game/actie', [GameController::class, 'actie'])->name('game.actie');
Route::get('/game/winkel', [GameController::class, 'winkel'])->name('game.winkel');
Route::post('/game/winkel/koop', [GameController::class, 'koop'])->name('game.koop');
Route::get('/game/over', [GameController::class, 'over'])->name('over');
Route::post('/game/restart', [GameController::class, 'restart'])->name('restart');
Route::get('/game/opnieuw', [GameController::class, 'opnieuw'])->name('opnieuw');
