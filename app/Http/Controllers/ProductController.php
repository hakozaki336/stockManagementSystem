<?php

namespace App\Http\Controllers;

use App\Exceptions\DomainValidationException;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\UseCases\Product\DestroyAction;
use App\UseCases\Product\IndexAction;
use App\UseCases\Product\PaginateAction;
use App\UseCases\Product\StoreAction;
use App\UseCases\Product\UpdateAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexAction $indexAction, Product $product): JsonResponse
    {
        $products = $indexAction($product);

        return response()->json([
            'data' => ProductResource::collection($products),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request, StoreAction $storeAction, Product $product): Response
    {
        $storeAction($product, $request->validated());

        return response()->noContent(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): ProductResource
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, UpdateAction $updateAction, Product $product): Response
    {
        $updateAction($product, $request->validated());

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyAction $destroyAction, Product $product): Response | JsonResponse
    {
        try {
            $destroyAction($product);
        } catch (DomainValidationException $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->noContent();
    }

    /**
     * pagenateされた製品データを取得する
     */
    public function pagenate(PaginateAction $paginateAction, Product $product, int $perPage = 5): JsonResponse
    {
        $products = $paginateAction($product, $perPage);

        return response()->json([
            'data' => ProductResource::collection($products),
            'links' => [
                'prev' => $products->previousPageUrl(),
                'next' => $products->nextPageUrl(),
                'current' => $products->url($products->currentPage()),
            ],
        ]);
    }
}
