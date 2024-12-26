<?php

namespace App\UseCases\Company;

use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;

class IndexAction
{
    private Company $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function __invoke(): Collection
    {
        return $this->company->all();
    }
}