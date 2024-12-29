<?php

namespace App\UseCases\Product;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginateAction
{
    public function __invoke(Product $product, int $perpage): LengthAwarePaginator
    {
        return $product->paginate($perpage);
    }
}