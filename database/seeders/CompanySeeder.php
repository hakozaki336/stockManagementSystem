<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = [
            ['name' => 'Company A'],
            ['name' => 'Company B'],
            ['name' => 'Company C'],
        ];

        foreach ($companies as $company) {
            Company::create($company);
        }
    }
}
