<?php

namespace App\UseCases\Company;

use App\Models\Company;

class StoreAction
{
    public function __invoke($company, array $param): bool
    {
        return $this->createCompany($company, $param);
    }

    /**
     * 企業を作成する
     */
    private function createCompany($company, array $param): bool
    {
        return $company->fill($param)->save();
    }
}