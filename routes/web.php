<?php

use Illuminate\Support\Facades\Route;
use Larapie\Larapie\Http\Controllers\LarapieController;

Route::get('/larapie', [LarapieController::class, 'index'])->name('larapie.index');