<?php

use App\Http\Controllers\DecodeController;
use App\Http\Controllers\EncodeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/encode', EncodeController::class);

Route::post('/decode', DecodeController::class);
