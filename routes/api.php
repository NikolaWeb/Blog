<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\ChangePasswordController;

// Auth routes
Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
Route::group(['middleware' => ['authJwt'], 'prefix' => 'auth'], function ($router) {
    Route::get('/whoami', [AuthController::class, 'whoami']);
});


// Configuracion fajl - šifarnici
Route::group(['middleware' => ['authJwt'], 'prefix' => 'config'], 
function ($router) {
    Route::get('/', [ConfigController::class, 'index']);
    Route::get('/{code}', [ConfigController::class, 'code']);
});

// Users
Route::group(['middleware' => ['authJwt'], 'prefix' => 'users'], 
function ($router) {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/show/{id}', [UserController::class, 'show']);
    Route::post('/store', [UserController::class, 'store']);
    Route::post('/update/{id}', [UserController::class, 'update']);
    Route::delete('/delete/{id}', [UserController::class, 'delete']);
});


Route::patch('/change-password', [ChangePasswordController::class, 'changePassword'])->middleware(['authJwt']);
