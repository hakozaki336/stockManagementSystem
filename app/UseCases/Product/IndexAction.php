<?php

namespace App\UseCases\Product;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class IndexAction
{
    private Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function __invoke(): Collection
    {
        return $this->product->all();
    }
}