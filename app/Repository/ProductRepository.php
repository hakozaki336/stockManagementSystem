<?php

namespace App\Repository;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository
{
    public function all(): Collection
    {
        return Product::all();
    }

    public function find(int $id): Product
    {
        return Product::findOrFail($id);
    }

    public function delete(Product $product): ?bool
    {
        return $product->delete();
    }

    public function paginate(int $perPage): LengthAwarePaginator
    {
        return Product::paginate($perPage);
    }

    public function create(array $params): Product
    {
        return Product::create($params);
    }

    public function update(Product $product, array $params): Product
    {
        $product->update($params);
        return $product;
    }

    public function getUnassignedInventories(Product $product): Collection
    {
        return $product->productInventories()->whereNull('order_id')->get();
    }

    public function getPaginateByProductInventories(Product $product, int $perPage): LengthAwarePaginator
    {
        return $product->productInventories()->paginate($perPage);
    }
}