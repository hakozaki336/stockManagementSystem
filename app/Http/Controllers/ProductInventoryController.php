<?php

namespace App\Http\Controllers;

use App\Exceptions\ProductInventoryHasOrdersException;
use App\Http\Requests\ProductInventoryStoreRequest;
use App\Http\Requests\ProductInventoryUpdateRequest;
use App\Http\Resources\ProductInventoryResource;
use App\Models\ProductInventory;
use App\UseCases\ProductInventory\DestroyAction;
use App\UseCases\ProductInventory\IndexAction;
use App\UseCases\ProductInventory\PaginateAction;
use App\UseCases\ProductInventory\PaginateByProductAction;
use App\UseCases\ProductInventory\PaginateByOrderAction;
use App\UseCases\ProductInventory\StoreAction;
use App\UseCases\ProductInventory\UpdateAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ProductInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexAction $indexAction): JsonResponse
    {
        $productInventories = $indexAction();

        return response()->json([
            'data' => ProductInventoryResource::collection($productInventories),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductInventoryStoreRequest $request, StoreAction $storeAction): Response
    {
        $storeAction($request->validated());

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
    public function update(ProductInventoryUpdateRequest $request, ProductInventory $productInventory, UpdateAction $updateAction): Response
    {
        $updateAction($productInventory, $request->validated());

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductInventory $productInventory, DestroyAction $destroyAction): Response | JsonResponse
    {
        try {
            $destroyAction($productInventory);
        } catch (ProductInventoryHasOrdersException $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->noContent();
    }

    public function byProduct(int $product_id, PaginateByProductAction $paginateByProductAction, int $perPage = 5): JsonResponse
    {
        $productInventories = $paginateByProductAction($product_id, $perPage);

        return response()->json([
            'data' => ProductInventoryResource::collection($productInventories),
            'links' => [
                'prev' => $productInventories->previousPageUrl(),
                'next' => $productInventories->nextPageUrl(),
                'current' => $productInventories->url($productInventories->currentPage()),
            ],
        ]);
    }

    public function byOrder(int $order_id, PaginateByOrderAction $paginateByOrderAction, int $perPage = 5): JsonResponse
    {
        $productInventories = $paginateByOrderAction($order_id, $perPage);

        return response()->json([
            'data' => ProductInventoryResource::collection($productInventories),
            'links' => [
                'prev' => $productInventories->previousPageUrl(),
                'next' => $productInventories->nextPageUrl(),
                'current' => $productInventories->url($productInventories->currentPage()),
            ],
        ]);
    }

    public function pagenate(int $product_id, int $perpage = 5, PaginateAction $paginateAction): JsonResponse
    {
        $productInventories = $paginateAction($perpage, $product_id);

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
