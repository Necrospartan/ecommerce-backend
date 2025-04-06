<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Media\MediaController;
use App\Http\Controllers\Reservation\ReservationController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function (){
    Route::middleware(['auth:sanctum'])->prefix('auth')->group(function (){
        Route::post('/login', 'login')->name('login')->withoutMiddleware(['auth:sanctum']);
        Route::get('/logout', 'logout')->name('logout');
        Route::get('/checkAuth', 'me')->name('me');
        Route::get('/refreshToken', 'refresh')->name('refreshToken');
    });
});

Route::controller(MediaController::class)->group(function (){
    Route::middleware(['auth:sanctum'])->prefix('media')->group(function (){
        Route::get('/getMedia', 'index')->name('getMedia')->withoutMiddleware(['auth:sanctum']);
        Route::get('/getMedia/{id}', 'show')->name('getMedia')->withoutMiddleware(['auth:sanctum']);
        Route::post('/addMedia', 'store')->name('addMedia')->middleware('checkRole:Admin');
        Route::put('/updateMedia/{id}', 'update')->name('updateMedia')->middleware('checkRole:Admin');
        Route::delete('/deleteMedia/{id}', 'destroy')->name('deleteMedia')->middleware('checkRole:Admin');
        //Image
        Route::get('/getImageMedia/{id}', 'getImageMedia')->name('getImageMedia')->withoutMiddleware(['auth:sanctum']);
    });
});

Route::controller(ReservationController::class)->group(function (){
    Route::middleware(['auth:sanctum'])->prefix('reservation')->group(function (){
        Route::get('/getReservation', 'index')->name('getReservation')->middleware('checkRole:Admin|Cliente');
        Route::get('/getReservation/{id}', 'show')->name('getReservation')->middleware('checkRole:Admin|Cliente');
        Route::post('/addReservation', 'store')->name('addReservation')->middleware('checkRole:Admin|Cliente');
        Route::put('/updateReservation/{id}', 'update')->name('updateReservation')->middleware('checkRole:Admin');
        Route::delete('/deleteReservation/{id}', 'destroy')->name('deleteReservation')->middleware('checkRole:Admin');
    });
});
