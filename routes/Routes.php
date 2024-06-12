<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Controllers\LikeController;
use Src\Foundation\Routing\RouteRegistration as Route;

Route::get('/home', [HomeController::class, 'index'])->name('home.index');
Route::get('/home/{id}', [HomeController::class, 'show'])->name('home.show');

Route::get('/user', [UserController::class, 'index'])->name('user.index');
Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show');

Route::get('/like', [LikeController::class, 'index'])->name('like.index');
Route::get('/like/{id}', [LikeController::class, 'show'])->name('like.show');


