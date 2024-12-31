<?php

use App\Http\Controllers\CodeOrderController;
use App\Http\Controllers\DetailOrdersController;
use App\Http\Controllers\OrdersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('orders', OrdersController::class);
Route::apiResource('checkout', DetailOrdersController::class);
Route::apiResource('test', CodeOrderController::class);

// Route::get('/test', CodeOrderController::class, 'index');
