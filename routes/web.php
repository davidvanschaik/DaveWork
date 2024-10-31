<?php

declare(strict_types=1);

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\LikeController;
use App\Controllers\PostController;
use App\Controllers\UserController;
use Src\Routing\RouteRegistration as Route;

Route::get('/login', [AuthController::class, 'index'])->name('login');

Route::post('/login', [AuthController::class, 'handle'])
    ->middleware('validation')
    ->middleware('verification')
    ->name('postLogin');

Route::get('/test', [PostController::class, 'index'])->name('test');

Route::get('/home', [HomeController::class, 'index'])
    ->name('home')
    ->middleware('permission');

Route::get('/home/user/{id}/post', [HomeController::class, 'user'])->name('home.user.show');

Route::get('/home/{id}', [HomeController::class, 'show'])
    ->name('home.show');

Route::get('/user', [UserController::class, 'index'])->name('user.index');
Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show');

Route::get('/like/{id}', [LikeController::class, 'show'])->name('like.show');
Route::get('/like', [LikeController::class, 'index'])
    ->middleware('permission')
    ->name('like.index');

