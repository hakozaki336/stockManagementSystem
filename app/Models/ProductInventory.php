<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
    public function getByProductId(int $product_id) : Collection
    {
        return $this->where('product_id', $product_id)->get();
    }
}
