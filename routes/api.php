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

// NOTE: ルートは上から順にマッチするため、順序に注意
// 例: GET orders/{order_id}/inventories が apiResource の GET /orders/show より上にあるとマッチしてしまう。

// Orders関連ルート
Route::prefix('orders')->group(function () {
    Route::patch('{order}/dispatch', [OrderController::class, 'dispatch']);
    Route::patch('{order}/undispatch', [OrderController::class, 'undispatch']);
    Route::get('{order_id}/inventories', [ProductInventoryController::class, 'byOrder']);
    Route::get('paginate', [OrderController::class, 'paginate']);
    Route::apiResource('', OrderController::class);
});

// Products関連ルート
Route::prefix('products')->group(function () {
    Route::get('paginate', [ProductController::class, 'paginate']);
    Route::get('{product_id}/inventories', [ProductInventoryController::class, 'paginateByProduct']);
    Route::get('{product_id}/unassigned-product-inventories', [ProductController::class, 'unassignedProductInventories']);
    Route::apiResource('', ProductController::class);
});

// Companies関連ルート
Route::prefix('companies')->group(function () {
    Route::get('paginate', [CompanyController::class, 'paginate']);
    Route::apiResource('', CompanyController::class);
});

// Product Inventories関連ルート
Route::apiResource('product-inventories', ProductInventoryController::class);
