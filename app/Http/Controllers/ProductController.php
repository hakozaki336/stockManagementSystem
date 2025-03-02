<?php

namespace App\Http\Controllers;

use App\Exceptions\DomainValidationException;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ApplicationServices\Product\ProductCreateService;
use App\Services\ApplicationServices\Product\ProductDeleteService;
use App\Services\ApplicationServices\Product\ProductListService;
use App\Services\ApplicationServices\Product\ProductPaginationService;
use App\Services\ApplicationServices\Product\ProductUpdateService;
use App\Services\ApplicationServices\Product\UnassignedProductInventoryCountService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductListService $productListService): AnonymousResourceCollection
    {
        $products = $productListService();

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request, ProductCreateService $productCreateService): Response
    {
        $productCreateService($request->validated());

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
    public function update(ProductUpdateRequest $request, ProductUpdateService $productUpdateService, Product $product): Response
    {
        $productUpdateService($product, $request->validated());

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductDeleteService $productDeleteService, Product $product): Response | JsonResponse
    {
        try {
            $productDeleteService($product);
        } catch (DomainValidationException $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->noContent();
    }

    /**
     * paginateされた製品データを取得する
     */
    public function paginate(ProductPaginationService $productPaginationService, int $perPage = 5): ProductCollection
    {
        $products = $productPaginationService($perPage);

        return new ProductCollection($products);
    }

    public function unassignedProductInventories(UnassignedProductInventoryCountService $unassignedProductInventoryCountService, Product $product): JsonResponse
    {
        $count = $unassignedProductInventoryCountService($product);

        return response()->json([
            'stock' => $count,
        ]);
    }
}
