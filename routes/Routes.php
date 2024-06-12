<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use App\Controllers\UserController;
use Src\Foundation\Routing\Route;

Route::get('/user/{id}', [UserController::class, 'index'])->name('home.index');
Route::get('/home/{id}', [HomeController::class, 'index'])->name('home.index');
