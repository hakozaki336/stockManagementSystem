<?php

namespace App\UseCases\Product;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginateAction
{
    private Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function __invoke(int $perpage): LengthAwarePaginator
    {
        return $this->product->paginate($perpage);
    }
}