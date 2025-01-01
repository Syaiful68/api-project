<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\DetailOrdersController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// orders
Route::apiResource('orders', OrdersController::class);

// detail order
Route::get('checkout', [DetailOrdersController::class, 'index']);
Route::get('checkout/submit', [DetailOrdersController::class, 'submit']);
Route::get('checkout/{checkout}', [DetailOrdersController::class, 'show']);
Route::patch('checkout/update/{checkout}', [DetailOrdersController::class, 'update']);

Route::apiResource('asset', AssetsController::class);
