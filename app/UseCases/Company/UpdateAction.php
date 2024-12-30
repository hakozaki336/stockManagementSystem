<?php

namespace App\UseCases\Company;

use App\Models\Company;

class UpdateAction
{
    public function __invoke(Company $company, array $param): Company
    {
        $company->fill($param)->save();

        return $company;
    }
}