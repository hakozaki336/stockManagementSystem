<?php

namespace App\Http\Controllers;

use App\Exceptions\ProductHasOrdersException;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $products = ProductService::getPaginatedProducts(5);

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
    public function store(ProductStoreRequest $request): Response
    {
        ProductService::create($request->validated());

        return response()->noContent(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): ProductResource
    {
        $product = new ProductService($id);

        return new ProductResource($product->getProduct());
    }

    /**
     * Update the specified resource in storage.
     */
  
    public function update(ProductUpdateRequest $request, int $id): Response
    {
        $productService = new ProductService($id);
        $productService->update($request->all());

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(int $id): Response | JsonResponse
    {
        $productService = new ProductService($id);
        try {
            $productService->delete();
        } catch (ProductHasOrdersException $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->noContent();
    }

    /**
     * selectOption用の商品データを返す
     */
    public function options(): JsonResponse
    {
       $products = ProductService::getProductsForSelectOption();

       return response()->json([
              'data' => ProductResource::collection($products),
        ]);
    }
}
