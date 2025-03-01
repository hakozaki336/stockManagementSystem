<?php

namespace App\Services\ApplicationServices\Company;

use App\Models\Company;
use App\Repository\CompanyRepository;

class CompanyCreateService
{
    protected CompanyRepository $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function __invoke(array $params): Company
    {
        return $this->companyRepository->create($params);
    }
}