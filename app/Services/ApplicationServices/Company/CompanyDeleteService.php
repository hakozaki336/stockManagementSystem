<?php

namespace App\Services\ApplicationServices\Company;

use App\Exceptions\CompanyHasOrdersException;
use App\Exceptions\DomainValidationException;
use App\Models\Company;
use App\Repository\CompanyRepository;

class CompanyDeleteService
{
    protected CompanyRepository $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function __invoke(Company $company): bool
    {
        try {
            $this->validateDomainRule($company);
        } catch (CompanyHasOrdersException $e) {
            throw new DomainValidationException($e->getMessage());
        }

        return $this->companyRepository->delete($company);
    }

    /**
     * MEMO: これは別クラスに切っても良いかもね
     * 削除のためのドメインルールを検証する
     */
    protected function validateDomainRule(Company $company): void
    {
        if ($company->hasOrders()) {
            throw new CompanyHasOrdersException();
        }
    }
}