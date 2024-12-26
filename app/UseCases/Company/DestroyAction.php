<?php

namespace App\UseCases\Company;

use App\Exceptions\CompanyHasOrdersException;
use App\Models\Company;

class DestroyAction
{
    public function __invoke(Company $company): void
    {
        $this->validateDomainRule($company);

        $company->delete();
    }

    /**
     * MEMO: これは別クラスに切っても良いかもね
     * 削除のためのドメインルールを検証する
     */
    private function validateDomainRule(Company $company): void
    {
        if ($company->hasOrders()) {
            throw new CompanyHasOrdersException();
        }
    }
}