<?php

namespace App\UseCases\Company;

use App\Models\Company;

class StoreAction
{
    public function __invoke($company, array $param): Company
    {
        $company->fill($param)->save();

        return $company;
    }
}