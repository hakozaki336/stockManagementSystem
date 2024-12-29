<?php

namespace App\Http\Controllers;

use App\Exceptions\CompanyHasOrdersException;
use App\Exceptions\DomainValidationException;
use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Http\Resources\CompanyResource;
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
    public function index(IndexAction $indexAction): JsonResponse
    {
        $companies = $indexAction();

        return response()->json([
            'data' => CompanyResource::collection($companies),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyStoreRequest $request, StoreAction $storeAction): Response
    {
        $storeAction($request->validated());

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
     * pagenateされた企業データを取得する
     */
    public function pagenate(PaginateAction $paginateAction, int $perpage = 5): JsonResponse
    {
        $companies = $paginateAction($perpage);

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
}
