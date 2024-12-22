<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductInventoryStoreRequest;
use App\Http\Requests\ProductInventoryUpdateRequest;
use App\Http\Resources\ProductInventoryResource;
use App\Models\Product;
use App\Models\ProductInventory;
use App\Services\ProductInventoryService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductInventoryController extends Controller
{
    private const PERPAGE = 5;

    /**
     * Display a listing of the resource.
     */
    public function index(int $product_id): JsonResponse
    {
        $productInventories = ProductInventoryService::getPaginatedProductInventories(self::PERPAGE, $product_id);

        return response()->json([
            'data' => ProductInventoryResource::collection($productInventories),
            'links' => [
                'prev' => $productInventories->previousPageUrl(),
                'next' => $productInventories->nextPageUrl(),
                'current' => $productInventories->url($productInventories->currentPage()),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductInventoryStoreRequest $request): Response
    {
        productInventoryService::store($request->all());

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
    public function update(ProductInventoryUpdateRequest $request, ProductInventory $productInventory): Response
    {
        productInventoryService::update($productInventory, $request->all());

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductInventory $productInventory): Response
    {
        productInventoryService::delete($productInventory);

        return response()->noContent();
    }

    public function byProduct(int $product_id): JsonResponse
    {
        $productInventories = ProductInventoryService::getPaginateProductInventoryByProducts($product_id);

        return response()->json([
            'data' => ProductInventoryResource::collection($productInventories),
            'links' => [
                'prev' => $productInventories->previousPageUrl(),
                'next' => $productInventories->nextPageUrl(),
                'current' => $productInventories->url($productInventories->currentPage()),
            ],
        ]);
    }

    public function byOrder(int $order_id): JsonResponse
    {
        $productInventories = ProductInventoryService::getPaginateProductInventoryByOrders($order_id);

        return response()->json([
            'data' => ProductInventoryResource::collection($productInventories),
            'links' => [
                'prev' => $productInventories->previousPageUrl(),
                'next' => $productInventories->nextPageUrl(),
                'current' => $productInventories->url($productInventories->currentPage()),
            ],
        ]);
    }
}
