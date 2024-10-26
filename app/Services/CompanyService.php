<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Pagination\LengthAwarePaginator;

class CompanyService
{
    public static function getPaginatedCompaneis(int $perpage): LengthAwarePaginator
    {
        $paginatedCompanies = Company::paginate($perpage);

        return $paginatedCompanies;
    }

    public function create(array $param): void
    {
        Company::create($param);
    }

    public function update(Company $company, array $param): void
    {
        $company->update($param);
    }

    public function delete(Company $company): void
    {
        $company->delete();
    }

    public function getCompany(int $id): Company
    {
        return Company::findOrFail($id);
    }
}