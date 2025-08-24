<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'seller_id',
        'title',
        'type',
        'genre',
        'duration',
        'platform',
        'price',
        'released_date',
        'age_rating',
        'size',
        'description',
        'product_photo_path',
        'company',
    ];

    protected $casts = [
        'price'         => 'decimal:2',
        'released_date' => 'date',
        'size'          => 'decimal:2',
        'age_rating'    => 'integer',
    ];

    public static array $platforms = ['PC', 'XBOX', 'PS4', 'PS5'];
    public static array $genres = ['Shooter', 'RPG', 'Racing'];
    public static array $type = ['digital', 'physical'];

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
