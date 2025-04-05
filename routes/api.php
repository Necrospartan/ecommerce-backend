<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function (){
    Route::middleware(['auth:sanctum'])->prefix('auth')->group(function (){
        Route::post('/login', 'login')->name('login')->withoutMiddleware(['auth:sanctum']);
        Route::get('/logout', 'logout')->name('logout');
        Route::get('/checkAuth', 'me')->name('me');
        Route::get('/refreshToken', 'refresh')->name('refreshToken');
    });
});
