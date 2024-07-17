<?php

declare(strict_types=1);

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\LikeController;
use App\Controllers\UserController;
use Src\Routing\RouteRegistration as Route;

Route::get('/home', [HomeController::class, 'index'])->name('home.index');
Route::get('/home/{id}', [HomeController::class, 'show'])->name('home.show');

Route::get('/user', [UserController::class, 'index'])->name('user.index');
Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show');

Route::get('/like', [LikeController::class, 'index'])->name('like.index');
Route::get('/like/{id}', [LikeController::class, 'show'])->name('like.show');

Route::get('/home/user/{id}/post', [HomeController::class, 'user'])->name('home.user.show');

Route::get('/login', [AuthController::class, 'make'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('validation');
Route::get('/test', [AuthController::class, 'login'])->name('kanker');

