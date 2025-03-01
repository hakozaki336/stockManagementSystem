<?php

namespace App\Services\ApplicationServices\Company;

use App\Models\Company;
use App\Repository\CompanyRepository;

class CompanyUpdateService
{
    protected CompanyRepository $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function __invoke(Company $company, array $params): Company
    {
        return $this->companyRepository->update($company, $params);
    }
}