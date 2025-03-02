<?php

namespace App\Http\Controllers;

use App\Exceptions\DomainValidationException;
use App\Http\Requests\ProductInventoryStoreRequest;
use App\Http\Requests\ProductInventoryUpdateRequest;
use App\Http\Resources\ProductInventoryResource;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductInventory;
use App\UseCases\ProductInventory\PaginateAction;
use App\UseCases\ProductInventory\PaginateByProductAction;
use App\UseCases\ProductInventory\PaginateByOrderAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use App\Http\Resources\ProductInventoryCollection;
use App\Services\ApplicationServices\ProductInventory\ProductInventoryCreateService;
use App\Services\ApplicationServices\ProductInventory\ProductInventoryDeleteService;
use App\Services\ApplicationServices\ProductInventory\ProductInventoryListService;
use App\Services\ApplicationServices\ProductInventory\ProductInventoryPaginationService;
use App\Services\ApplicationServices\ProductInventory\ProductInventoryUpdateService;

class ProductInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductInventoryListService $productInventoryListService): AnonymousResourceCollection
    {
        $productInventories = $productInventoryListService();

        return ProductInventoryResource::collection($productInventories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductInventoryStoreRequest $request, ProductInventoryCreateService $productInventoryCreateService): Response
    {
        $productInventoryCreateService($request->validated());

        return response()->noContent(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductInventory $productInventory): ProductInventoryResource
    {
        return new ProductInventoryResource($productInventory);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductInventoryUpdateRequest $request, ProductInventoryUpdateService $productInventoryUpdateService, ProductInventory $productInventory): Response
    {
        $productInventoryUpdateService($productInventory, $request->validated());

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductInventoryDeleteService $productInventoryDeleteService, ProductInventory $productInventory): Response | JsonResponse
    {
        try {
            $productInventoryDeleteService($productInventory);
        } catch (DomainValidationException $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->noContent();
    }

    // MEMO: 複数を返すのでProductsじゃね
    // MEMO これはここに書くべきか？
    public function paginateByProduct(Product $product, PaginateByProductAction $paginateByProductAction, int $perPage = 5): ProductInventoryCollection
    {
        $productInventories = $paginateByProductAction($product, $perPage);

        return new ProductInventoryCollection($productInventories);
    }

    // MEMO これはここに書くべきか？
    public function byOrder(Order $order, PaginateByOrderAction $paginateByOrderAction, int $perPage = 5): ProductInventoryCollection
    {
        $productInventories = $paginateByOrderAction($order, $perPage);

        return new ProductInventoryCollection($productInventories);
    }

    public function paginate(ProductInventoryPaginationService $productInventoryPaginationService, productInventory $productInventory, int $perPage = 5): ProductInventoryCollection
    {
        $productInventories = $productInventoryPaginationService($productInventory, $perPage);

        return new ProductInventoryCollection($productInventories);
    }
}
