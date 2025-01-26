<?php

namespace App\Http\Controllers;

use App\Exceptions\DomainValidationException;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductOptionResource;
use App\Models\Product;
use App\UseCases\Product\DestroyAction;
use App\UseCases\Product\IndexAction;
use App\UseCases\Product\PaginateAction;
use App\UseCases\Product\StoreAction;
use App\UseCases\Product\UpdateAction;
use App\UseCases\ProductInventory\UnassignedProductsAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexAction $indexAction, Product $product): AnonymousResourceCollection
    {
        $products = $indexAction($product);

        return ProductResource::collection($products);
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
    public function show(Product $product): ProductOptionResource
    {
        return new ProductOptionResource($product);
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
     * paginateされた製品データを取得する
     */
    public function paginate(PaginateAction $paginateAction, Product $product, int $perPage = 5): ProductCollection
    {
        $products = $paginateAction($product, $perPage);

        return new ProductCollection($products);
    }

    public function unassignedProductInventories(Product $product, UnassignedProductsAction $unassignedProductsAction): JsonResponse
    {
        $productInventories = $unassignedProductsAction($product);

        return response()->json([
                'stock' => $productInventories->count() ?? 0,
        ]);
    }
}
