<?php

namespace Database\Seeders;

use App\Models\ProductInventory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductInventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productInventories = [
            [
                'product_id' => 1,
                'serial_number' => 'SN001',
                'location' => 'A1',
                'expiration_date' => '2030-01-01',
                'dispatched' => true,
            ],
            [
                'product_id' => 1,
                'serial_number' => 'SN002',
                'location' => 'A2',
                'expiration_date' => '2030-01-01',
                'dispatched' => false,
            ],
            [
                'product_id' => 2,
                'serial_number' => 'SN003',
                'location' => 'B1',
                'expiration_date' => '2030-01-01',
                'dispatched' => true,
            ],
            [
                'product_id' => 2,
                'serial_number' => 'SN004',
                'location' => 'B2',
                'expiration_date' => '2030-01-01',
                'dispatched' => false,
            ],
            [
                'product_id' => 3,
                'serial_number' => 'SN005',
                'location' => 'C1',
                'expiration_date' => '2030-01-01',
                'dispatched' => true,
            ],
            [
                'product_id' => 3,
                'serial_number' => 'SN006',
                'location' => 'C2',
                'expiration_date' => '2030-01-01',
                'dispatched' => false,
            ],
        ];

        foreach ($productInventories as $productInventory) {
            ProductInventory::create($productInventory);
        }
    }
}
