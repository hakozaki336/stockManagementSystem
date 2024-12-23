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
                'order_id' => 1,
            ],
            [
                'product_id' => 1,
                'serial_number' => 'SN002',
                'location' => 'A2',
                'expiration_date' => '2030-01-01',
                'order_id' => null,
            ],
            [
                'product_id' => 2,
                'serial_number' => 'SN003',
                'location' => 'B1',
                'expiration_date' => '2030-01-01',
                'order_id' => 2,
            ],
            [
                'product_id' => 2,
                'serial_number' => 'SN004',
                'location' => 'B2',
                'expiration_date' => '2030-01-01',
                'order_id' => null,
            ],
            [
                'product_id' => 3,
                'serial_number' => 'SN005',
                'location' => 'C1',
                'expiration_date' => '2030-01-01',
                'order_id' => 3,
            ],
            [
                'product_id' => 3,
                'serial_number' => 'SN006',
                'location' => 'C2',
                'expiration_date' => '2030-01-01',
                'order_id' => null,
            ],
            [
                'product_id' => 1,
                'serial_number' => 'SN007',
                'location' => 'A3',
                'expiration_date' => '2030-01-01',
                'order_id' => null,
            ],
            [
                'product_id' => 1,
                'serial_number' => 'SN008',
                'location' => 'A4',
                'expiration_date' => '2030-01-01',
                'order_id' => null,
            ],
            [
                'product_id' => 1,
                'serial_number' => 'SN009',
                'location' => 'A5',
                'expiration_date' => '2030-01-01',
                'order_id' => null,
            ],
            [
                'product_id' => 1,
                'serial_number' => 'SN010',
                'location' => 'A6',
                'expiration_date' => '2030-01-01',
                'order_id' => null,
            ],
            [
                'product_id' => 1,
                'serial_number' => 'SN011',
                'location' => 'A7',
                'expiration_date' => '2030-01-01',
                'order_id' => null,
            ],
            [
                'product_id' => 1,
                'serial_number' => 'SN012',
                'location' => 'A8',
                'expiration_date' => '2030-01-01',
                'order_id' => null,
            ],
            [
                'product_id' => 1,
                'serial_number' => 'SN013',
                'location' => 'A9',
                'expiration_date' => '2030-01-01',
                'order_id' => null,
            ],
            [
                'product_id' => 1,
                'serial_number' => 'SN014',
                'location' => 'A10',
                'expiration_date' => '2030-01-01',
                'order_id' => null,
            ],
        ];

        foreach ($productInventories as $productInventory) {
            ProductInventory::create($productInventory);
        }
    }
}
