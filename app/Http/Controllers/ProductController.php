<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

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

        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, string $id): Response
    {
        $productService = new ProductService($id);
        $productService->update($request->all());

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): Response
    {
        $productService = new ProductService($id);
        $productService->delete();

        return response()->noContent();
    }
}
