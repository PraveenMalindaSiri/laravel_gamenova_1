<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductRevenue extends Model
{
    protected $fillable = ['product_id', 'seller_id', 'units_sold', 'gross_revenue'];

    protected $casts = [
        'units_sold'    => 'integer',
        'gross_revenue' => 'decimal:2',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
