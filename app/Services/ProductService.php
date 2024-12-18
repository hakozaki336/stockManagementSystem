<?php

namespace App\Services;

use App\Exceptions\StockNotAvailableException;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService
{
    private Product $product;

    // TODO: IDで振る舞いを固定してしまうと、テストがしにくくなるので、IDではなくProductを受け取るようにするのが良いかもしれない
    public function __construct(int $id)
    {
        $this->product = Product::findOrFail($id);
    }

    /**
     * ページネーションされたOrderを取得する
     */
    public static function getPaginatedProducts(int $perPage): LengthAwarePaginator
    {
        // TODO: リポジトリを使ってみるのも良いかもしれない
        $paginatedProducts = Product::paginate($perPage);

        return $paginatedProducts;
    }

    public static function create(array $param): void
    {
        // TODO: 自身を返すようにするのも良いかもしれない
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

    public function delete(): void
    {
        $this->product->delete();
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function update(array $param): void
    {
        $this->product->update($param);
    }
}
