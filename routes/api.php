<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductAreaController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductInventoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


// NOTE: ルートは上から順にマッチするため、順序に注意
// 例: GET orders/{order_id}/inventories が apiResource の GET /orders/show より上にないとshowとマッチしてしまう。

// Orders関連ルート
Route::prefix('orders')->group(function () {
    Route::patch('{order}/assign', [OrderController::class, 'assign']);
    Route::patch('{order}/unassign', [OrderController::class, 'unassign']);
    Route::get('{order}/inventories', [ProductInventoryController::class, 'byOrder']);
    Route::get('paginate', [OrderController::class, 'paginate']);
    Route::apiResource('', OrderController::class)->parameters(['' => 'order']);
});

// Products関連ルート
Route::prefix('products')->group(function () {
    Route::get('paginate', [ProductController::class, 'paginate']);
    Route::get('{product}/inventories', [ProductInventoryController::class, 'paginateByProduct']);
    Route::get('{product}/unassigned-product-inventories', [ProductController::class, 'unassignedProductInventories']);
    Route::apiResource('', ProductController::class)->parameters(['' => 'product']);
});

// Product Area関連ルート
Route::prefix('product-areas')->group(function () {
    Route::apiResource('', ProductAreaController::class)->parameters(['' => 'product_areas']);
});

// Companies関連ルート
Route::prefix('companies')->group(function () {
    Route::get('paginate', [CompanyController::class, 'paginate']);
    Route::apiResource('', CompanyController::class)->parameters(['' => 'company']);
});

// Product Inventories関連ルート
Route::prefix('product_inventories')->group(function () {
    Route::apiResource('', ProductInventoryController::class)->parameters(['' => 'product_inventory']);
});
