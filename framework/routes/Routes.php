<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use App\Controllers\UserController;
use Src\Foundation\Routing\Route;

Route::get('/home', [HomeController::class, 'index'])->name('home.index');
Route::get('/user', [UserController::class, 'index'])->name('home.index');