<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'area',
        'stock_management_type',
    ];

    /**
     * @return HasMany<Order>
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * @return HasMany<ProductInventory>
     */
    public function productInventories(): HasMany
    {
        return $this->hasMany(ProductInventory::class);
    }

    public function hasOrders(): bool
    {
        // MEMO: exists()にするとクエリが発行されるのでcount()で判定する
        return $this->orders->count() > 0;
    }

    public function hasProductInventories(): bool
    {
        // MEMO: exists()にするとクエリが発行されるのでcount()で判定する
        return $this->productInventories->count() > 0;
    }
}
