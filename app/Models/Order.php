<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'product_id',
        'company_id',
        'order_count',
        'assign',
    ];

    protected $casts = [
        'assign' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
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
     * @return HasOne<ProductInventory>
     */
    public function productInventory(): HasOne
    {
        // TODO: camelになってないのはなぜか調べる
        // MEMO: 気のせいやと思うけどこれリレーション間違ってね？
        return $this->HasOne(ProductInventory::class);
    }

    /**
     * Order.assignを割り当て済みにする
     */
    public function assign(): static
    {
        $this->assign = true;
        return $this;
    }

    /**
     * Order.assignを未割り当てにする
     */
    public function unassign(): static
    {
        $this->assign = false;
        return $this;
    }
}
