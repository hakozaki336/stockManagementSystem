<?php

namespace App\UseCases\ProductInventory;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginateByProductAction
{
    public function __invoke(Product $product, int $perpage): LengthAwarePaginator
    {
        // MEMO: ここでproductInventories()を使うことで、ProductInventoryモデルのリレーションを使っている認識
        // NOTE: resource側で形成してproductInventoriesのみを返している
        return $product
            ->productInventories()
            ->paginate($perpage);
    }
}