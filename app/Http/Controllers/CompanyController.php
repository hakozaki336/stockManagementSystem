<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Services\CompanyService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class CompanyController extends Controller
{
    private CompanyService $companyService;

    public function __construct()
    {
        $this->companyService = new CompanyService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $companies = CompanyService::getPaginatedCompaneis(5);
        } catch (Exception) {
            return response()->json(['message' => 'サーバー側でエラーが発生しました'], 500);
        }

        return response()->json([
            'data' => CompanyResource::collection($companies),
            'links' => [
                'prev' => $companies->previousPageUrl(),
                'next' => $companies->nextPageUrl(),
                'current' => $companies->url($companies->currentPage()),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyStoreRequest $request): JsonResponse
    {
        try {
            $this->companyService->create($request->validated());
        } catch (ModelNotFoundException) {
            return response()->json(['message' => '会社が見つかりません'], 404);
        } catch (Exception) {
            return response()->json(['message' => 'サーバー側でエラーが発生しました'], 500);
        }

        return response()->json(null, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $company = $this->companyService->getCompany($id);
        } catch (ModelNotFoundException) {
            return response()->json(['message' => '会社が見つかりません'], 404);
        } catch (Exception) {
            return response()->json(['message' => 'サーバー側でエラーが発生しました'], 500);
        }

        return response()->json(new CompanyResource($company));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyUpdateRequest $request, Company $company): JsonResponse
    {
        try {
            $this->companyService->update($company, $request->validated());
        } catch (ModelNotFoundException) {
            return response()->json(['message' => '会社が見つかりません'], 404);
        } catch (Exception) {
            return response()->json(['message' => 'サーバー側でエラーが発生しました'], 500);
        }

        return response()->json(null, 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company): JsonResponse
    {
        try {
            $this->companyService->delete($company);
        } catch (ModelNotFoundException) {
            return response()->json(['message' => '会社が見つかりません'], 404);
        } catch (Exception) {
            return response()->json(['message' => 'サーバー側でエラーが発生しました'], 500);
        }

        return response()->json(null, 204);
    }
}
