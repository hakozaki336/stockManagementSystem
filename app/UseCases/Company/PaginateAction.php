<?php

namespace App\UseCases\Company;

use App\Models\Company;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginateAction
{
    public function __invoke(Company $company, int $perpage): LengthAwarePaginator
    {
        return $company->paginate($perpage);
    }
}