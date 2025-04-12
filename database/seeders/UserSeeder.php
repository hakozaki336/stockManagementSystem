<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'Test User', 'email' => 'test1@example.com', 'company_id' => 1],
            ['name' => 'Test User', 'email' => 'test2@example.com', 'company_id' => 2],
            ['name' => 'Test User', 'email' => 'test3@example.com', 'company_id' => 3],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
