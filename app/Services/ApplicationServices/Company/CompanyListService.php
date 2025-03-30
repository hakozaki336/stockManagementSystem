<?php

namespace App\Services\ApplicationServices\Company;

use App\Repository\CompanyRepository;
use Illuminate\Database\Eloquent\Collection;

class CompanyListService
{
    protected CompanyRepository $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function __invoke(): Collection
    {
        return $this->companyRepository->all();
    }
}