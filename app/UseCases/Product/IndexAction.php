<?php

namespace App\UseCases\Product;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class IndexAction
{
    public function __invoke(Product $product): Collection
    {
        return $product->all();
    }
}