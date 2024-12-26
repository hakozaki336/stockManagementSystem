<?php

namespace App\Services;

use App\Exceptions\OutOfStockException;
use App\Exceptions\ProductHasOrdersException;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
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
        $paginatedProducts = Product::with(['productInventories' => function ($query) {
            $query->where('order_id', null);
        }])->paginate($perPage);

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
            throw new OutOfStockException('在庫が足りません');
        }
    }

    public function delete(): void
    {
        $this->validateDomainRuleForDelete($this->product);
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

    /**
     * 削除のためのドメインルールを検証する
     */
    private function validateDomainRuleForDelete(Product $product): void
    {
        if (self::hasReferenceFromOrders($product)) {
            throw new ProductHasOrdersException();
        }
    }

    /**
     * ordersから参照があるか
     */
    private function hasReferenceFromOrders(Product $product): bool
    {
        return $product->orders()->exists();
    }

    /**
     * すべてのProductを取得する
     */
    public static function getAll(): Collection
    {
        return Product::all();
    }
}
