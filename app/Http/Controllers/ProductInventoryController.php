<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductInventoryStoreRequest;
use App\Http\Requests\ProductInventoryUpdateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductInventoryResource;
use App\Models\ProductInventory;
use App\Services\ProductInventoryService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductInventoryController extends Controller
{
    private $productInventoryService;
    private const PERPAGE = 5;

    public function __construct()
    {
        $this->productInventoryService = new ProductInventoryService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(int $product_id): JsonResponse
    {
        try {
            $productInventories = $this->productInventoryService->getPaginatedProductInventories(self::PERPAGE, $product_id);
        } catch (Exception) {
            return response()->json(['message' => 'サーバー側でエラーが発生しました'], 500);
        }

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
    public function store(ProductInventoryStoreRequest $request): JsonResponse
    {
        try {
            $this->productInventoryService->store($request->all());
        } catch (ModelNotFoundException) {
            return response()->json(['message' => '指定されたIDのデータが存在しません'], 404);
        } catch (Exception) {
            return response()->json(['message' => 'サーバー側でエラーが発生しました'], 500);
        }

        return response()->json(null, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductInventory $productInventory)
    {
        return response()->json(new ProductInventoryResource($productInventory));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductInventoryUpdateRequest $request, ProductInventory $productInventory)
    {
        try {
            $this->productInventoryService->update($productInventory, $request->all());
        } catch (ModelNotFoundException) {
            return response()->json(['message' => '指定されたIDのデータが存在しません'], 404);
        } catch (Exception) {
            return response()->json(['message' => 'サーバー側でエラーが発生しました'], 500);
        }

        return response()->json(null, 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductInventory $productInventory)
    {
        try {
            $this->productInventoryService->delete($productInventory);
        } catch (ModelNotFoundException) {
            return response()->json(['message' => '指定されたIDのデータが存在しません'], 404);
        } catch (Exception) {
            return response()->json(['message' => 'サーバー側でエラーが発生しました'], 500);
        }

        return response()->json(null, 204);
    }
}
