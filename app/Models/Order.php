<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'company_id',
        'order_count',
    ];
    /**
     * @return BelongsTo<Product>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return BelongsTo<Company>
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * true: 出荷済み, false: 未出荷 を返す
     */
    public function getDispatchedAttribute(): string
    {
        return $this->attributes['dispatched'] ? '出荷済み' : '未出荷';
    }

    /**
     * created_atを日本時間のフォーマットで返す
     *
     * @return string
     */
    public function getCreatedAtAttribute(): string
    {
        return Carbon::parse($this->attributes['created_at'])
            ->setTimezone('Asia/Tokyo')
            ->format('Y-m-d H:i:s');
    }
}
