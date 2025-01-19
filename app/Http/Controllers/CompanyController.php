<?php

namespace App\Http\Controllers;

use App\Exceptions\DomainValidationException;
use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Http\Resources\CompanyCollection;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\PaginationCompanyResource;
use App\Http\Resources\PaginationResourceBase;
use App\Models\Company;
use App\UseCases\Company\DestroyAction;
use App\UseCases\Company\IndexAction;
use App\UseCases\Company\PaginateAction;
use App\UseCases\Company\StoreAction;
use App\UseCases\Company\UpdateAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexAction $indexAction, Company $company): JsonResponse
    {
        $companies = $indexAction($company);

        return response()->json([
            'data' => CompanyResource::collection($companies),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyStoreRequest $request, StoreAction $storeAction, Company $company): Response
    {
        $storeAction($company, $request->validated());

        return response()->noContent(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company): CompanyResource
    {
        return new CompanyResource($company);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyUpdateRequest $request, Company $company, UpdateAction $updateAction): Response
    {
        $updateAction($company, $request->validated());

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Company $company, DestroyAction $destroyAction): Response | JsonResponse
    {
        try {
            $destroyAction($company);
        } catch (DomainValidationException $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->noContent();
    }

    /**
     * paginateされた企業データを取得する
     */
    public function paginate(PaginateAction $paginateAction, Company $company, int $perpage = 5): CompanyCollection
    {
        $companies = $paginateAction($company, $perpage);

        return  new CompanyCollection($companies);
    }
}
