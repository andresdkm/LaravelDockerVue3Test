<?php

use App\Http\Controllers\CompetitionsAPIController;
use Illuminate\Support\Facades\Route;

Route::get('/competitions', [CompetitionsAPIController::class, 'index']);

