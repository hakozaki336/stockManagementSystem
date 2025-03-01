<?php

namespace App\Http\Controllers;

use App\Exceptions\DomainValidationException;
use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Http\Resources\CompanyCollection;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Services\ApplicationServices\Company\CompanyCreateService;
use App\Services\ApplicationServices\Company\CompanyDeleteService;
use App\Services\ApplicationServices\Company\CompanyListService;
use App\Services\ApplicationServices\Company\CompanyPaginationService;
use App\Services\ApplicationServices\Company\CompanyUpdateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CompanyListService $companyListService, Company $company): AnonymousResourceCollection
    {
        $companies = $companyListService($company);

        return CompanyResource::collection($companies);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyStoreRequest $request, CompanyCreateService $companyCreateService): Response
    {
        $companyCreateService($request->validated());

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
    public function update(CompanyUpdateRequest $request, CompanyUpdateService $companyUpdateService, Company $company): Response
    {
        $companyUpdateService($company, $request->validated());

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CompanyDeleteService $companyDeleteService, Company $company): Response | JsonResponse
    {
        try {
            $companyDeleteService($company);
        } catch (DomainValidationException $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->noContent();
    }

    /**
     * paginateされた企業データを取得する
     */
    public function paginate(CompanyPaginationService $companyPaginationService, int $prePage = 5): CompanyCollection
    {
        $companies = $companyPaginationService($prePage);

        return new CompanyCollection($companies);
    }
}
