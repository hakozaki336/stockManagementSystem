<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
