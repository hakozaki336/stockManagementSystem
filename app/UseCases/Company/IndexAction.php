<?php

namespace App\UseCases\Company;

use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;

class IndexAction
{
    public function __invoke($company): Collection
    {
        return $company->all();
    }
}