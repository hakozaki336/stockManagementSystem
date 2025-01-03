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
Route::patch('orders/{order}/dispatch', [OrderController::class, 'dispatch']);
Route::patch('orders/{order}/undispatch', [OrderController::class, 'undispatch']);
Route::get('orders/{order_id}/inventories', [ProductInventoryController::class, 'byOrder']);
Route::get('orders/paginate', [OrderController::class, 'paginate']);
Route::apiResource('orders', OrderController::class);
// NOTE: 遺言 順番変えたら死にます。laravelは上から舐めていくのでgetでproductsを呼ぶとshowが呼ばれてしまう
Route::get('products/paginate', [ProductController::class, 'paginate']);
Route::get('products/{product_id}/inventories', [ProductInventoryController::class, 'paginateByProduct']);
Route::get('products/{product_id}/unassigned-productInventories', [ProductController::class, 'unassignedProductInventories']);
Route::apiResource('products', ProductController::class);
Route::get('companies/paginate', [CompanyController::class, 'paginate']);
Route::apiResource('companies', CompanyController::class);
Route::apiResource('product-inventories', ProductInventoryController::class);
