<?php

namespace App\Services;

use App\Exceptions\StockNotAvailableException;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    private Product $product;

    public function __construct(int $id)
    {
        $this->product = Product::findOrFail($id);
    }

    public static function getAll(): Collection
    {
        return Product::all();
    }

    public function create(array $param): void
    {
        Product::create($param);
    }

    public function increaseStock(int $count): void
    {
        $this->product->stock += $count;
        $this->product->save();
    }

    public function decreaseStock(int $count): void
    {
        $this->checkStock($count);
        $this->product->stock -= $count;
        $this->product->save();
    }

    /**
     * 在庫がマイナスにならないかチェックする
     */
    private function checkStock(int $count): void
    {
        if ($this->product->stock < $count) {
            throw new StockNotAvailableException('在庫が足りません');
        }
    }

}
