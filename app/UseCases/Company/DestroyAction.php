<?php

namespace App\UseCases\Company;

use App\Exceptions\CompanyHasOrdersException;
use App\Exceptions\DomainValidationException;
use App\Models\Company;

class DestroyAction
{
    public function __invoke(Company $company): bool
    {
        try {
            $this->validateDomainRule($company);
        } catch (CompanyHasOrdersException $e) {
            throw new DomainValidationException($e->getMessage());
        }

        return $company->delete();
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