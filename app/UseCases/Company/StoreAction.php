<?php

namespace App\UseCases\Company;

use App\Models\Company;

class StoreAction
{
    private Company $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function __invoke(array $param): Company
    {
        $this->company->fill($param)->save();

        return $this->company;
    }
}