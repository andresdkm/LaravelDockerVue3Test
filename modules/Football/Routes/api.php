<?php
use Illuminate\Support\Facades\Route;
use Modules\Football\Controllers\CompetitionsAPIController;

Route::get('/competitions', [CompetitionsAPIController::class, 'index'])->name('competitions.index');
Route::get('/competitions/{id}', [CompetitionsAPIController::class, 'show'])->name('competitions.show');
Route::get('/competitions/{id}/matches/{date}', [\Modules\Football\Controllers\MatchesAPIController::class, 'index'])->name('matches.index');
