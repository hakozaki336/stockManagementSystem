<?php

namespace App\UseCases\Company;

use App\Models\Company;

class UpdateAction
{
    public function __invoke(Company $company, array $param): bool
    {
        return $this->updateCompany($company, $param);

        return $company;
    }

    /**
     * 企業を更新する
     */
    protected function updateCompany(Company $company, array $param): bool
    {
        return $company->fill($param)->save();
    }
}