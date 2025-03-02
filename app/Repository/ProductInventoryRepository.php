<?php

namespace App\Repository;

use App\Models\ProductInventory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductInventoryRepository
{
    public function all(): Collection
    {
        return ProductInventory::all();
    }

    public function delete(ProductInventory $productInventory): ?bool
    {
        return $productInventory->delete();
    }

    public function paginate(int $perPage): LengthAwarePaginator
    {
        return ProductInventory::paginate($perPage);
    }

    public function create(array $params): ProductInventory
    {
        return ProductInventory::create($params);
    }

    public function update(ProductInventory $productInventory, array $params): ProductInventory
    {
        $productInventory->update($params);
        return $productInventory;
    }
}