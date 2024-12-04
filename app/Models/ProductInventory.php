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
        'dispatched',
    ];

    /**
     * @return BelongsTo<Product>
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * アクセサを使ってtinyintをboolに変換
     */
    public function getDispatchedAttribute($value)
    {
        return (bool) $value;
    }

    /**
     * ミューテータを使ってboolをtinyintに変換
     */
    public function setDispatchedAttribute($value)
    {
        $this->attributes['dispatched'] = (int) $value;
    }
}
