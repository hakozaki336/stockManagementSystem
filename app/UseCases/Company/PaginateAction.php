<?php

namespace App\UseCases\Company;

use App\Models\Company;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginateAction
{
    private Company $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function __invoke(int $perpage): LengthAwarePaginator
    {
        return $this->company->paginate($perpage);
    }
}