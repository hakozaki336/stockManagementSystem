<?php

namespace App\Http\Controllers;

use App\Exceptions\CompanyHasOrdersException;
use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Services\CompanyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

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
        $companies = CompanyService::getPaginatedCompaneis(5);

        // MEMO: リソースを直接返さないのはaddtionalでリンク情報を追加するとprevとnextがnullにならないため
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
    public function store(CompanyStoreRequest $request): Response
    {
        $this->companyService->create($request->validated());

        return response()->noContent(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): CompanyResource
    {
        $company = $this->companyService->getCompany($id);

        return new CompanyResource($company);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyUpdateRequest $request, Company $company): Response
    {
        $this->companyService->update($company, $request->validated());

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company): Response | JsonResponse
    {
        try {
            $this->companyService->delete($company);
        } catch (CompanyHasOrdersException $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->noContent();
    }
}
