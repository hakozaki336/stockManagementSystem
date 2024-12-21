<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $products = ProductService::getPaginatedProducts(5);
        } catch (Exception) {
            return response()->json(['message' => 'サーバー側でエラーが発生しました'], 500);
        }

        return response()->json([
            'data' => ProductResource::collection($products),
            'links' => [
                'prev' => $products->previousPageUrl(),
                'next' => $products->nextPageUrl(),
                'current' => $products->url($products->currentPage()),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        try {
            ProductService::create($request->validated());
        } catch (Exception) {
            return response()->json(['message' => 'サーバー側でエラーが発生しました'], 500);
        }

        return response()->json(null, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            $product = new ProductService($id);
        } catch (ModelNotFoundException) {
            return response()->json(['message' => '指定された商品が見つかりませんでした'], 404);
        } catch (Exception) {
            return response()->json(['message' => 'サーバー側でエラーが発生しました'], 500);
        }

        return response()->json(new ProductResource($product->getProduct()));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, string $id)
    {
        try {
            $productService = new ProductService($id);
            $productService->update($request->all());
        } catch (ModelNotFoundException) {
            return response()->json(['message' => '指定された商品が見つかりませんでした'], 404);
        } catch (Exception) {
            return response()->json(['message' => 'サーバー側でエラーが発生しました'], 500);
        }

        return response()->json(null, 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $productService = new ProductService($id);
            $productService->delete();
        } catch (ModelNotFoundException) {
            return response()->json(['message' => '指定された商品が見つかりませんでした'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json(null, 204);
    }
}
