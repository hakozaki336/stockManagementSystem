<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;

class CompanyService
{
    public static function getAll(): Collection
    {
        return Company::all();
    }
}