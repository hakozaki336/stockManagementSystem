<?php

namespace App\Repository;

use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CompanyRepository
{
    public function all(): Collection
    {
        return Company::all();
    }

    public function delete(Company $company): ?bool
    {
        return $company->delete();
    }

    public function paginate(int $perPage): LengthAwarePaginator
    {
        return Company::paginate($perPage);
    }

    public function create(array $params): Company
    {
        return Company::create($params);
    }

    public function update(Company $company, array $params): Company
    {
        $company->update($params);
        return $company;
    }
}