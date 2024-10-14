<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $companies = productService::getAll();
        } catch (Exception) {
            return response()->json(['message' => 'サーバー側でエラーが発生しました'], 500);
        }

        return response()->json([
            'data' => ProductResource::collection($companies),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
