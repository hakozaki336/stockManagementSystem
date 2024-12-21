<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductInventoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// NOTE:　Laravelのルーティングでは、ルートは上から順にマッチするため、GET /orders/createがapiResourceのGET /ordersルートによって処理され、正しくcreateメソッドに到達しない
// Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
Route::apiResource('orders', OrderController::class);
Route::apiResource('products', ProductController::class);
Route::patch('/orders/{order}/dispatch', [OrderController::class, 'dispatch']);
Route::patch('/orders/{order}/undispatch', [OrderController::class, 'undispatch']);
Route::apiResource('companies', CompanyController::class);
Route::apiResource('product_inventories', ProductInventoryController::class);
Route::get('product_inventories/{product_id}/all', [ProductInventoryController::class, 'index']);