<?php

namespace App\Services\ApplicationServices\Company;

use App\Repository\CompanyRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class CompanyPaginationService
{
    protected CompanyRepository $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function __invoke(int $perPage): LengthAwarePaginator
    {
        return $this->companyRepository->paginate($perPage);
    }
}