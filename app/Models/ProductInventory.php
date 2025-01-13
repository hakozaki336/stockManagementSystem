<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'serial_number',
        'location',
        'expiration_date',
        'order_id',
    ];

    /**
     * @return BelongsTo<Product>
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function hasOrder(): bool
    {
        // MEMO: exists()にするとクエリが発行されるのでcount()で判定する
        return $this->order_id !== null;
    }

    /**
     * productに紐づく複数のproductInventoryを取得する
     */
    public function scopeByProductId($query, int $productId): Builder
    {
        return $query->where('product_id', $productId);
    }

    /**
     * orderに紐づく複数のproductInventoryを取得する
     */
    public function scopeByOrderId($query, int $orderId): Builder
    {
        return $query->where('order_id', $orderId);
    }

    /**
     * 割り当てられていない在庫を取得する
     */
    public function scopeUnAssigned($query): Builder
    {
        return $query->whereNull('order_id');
    }

    /**
     * 在庫を割り当てる
     */
    public function assign(int $orderId): static
    {
        $this->order_id = $orderId;
        return $this;
    }

    /**
     * 在庫を非割り当てにする
     */
    public function unAssign(): static
    {
        $this->order_id = null;
        return $this;
    }

    /**
     * 注文と一致するかどうかを確認する
     */
    public function isAssignedToOrder(int $orderId): bool
    {
        return $this->order_id === $orderId;
    }
}
