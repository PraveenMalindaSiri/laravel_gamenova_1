<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerCart extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerCartFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'grand_total',
    ];

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
