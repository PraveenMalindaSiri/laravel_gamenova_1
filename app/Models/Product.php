<?php

namespace App\Models;

use Illuminate\Contracts\Filesystem\Cloud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as BaseBuilder;
use Illuminate\Support\Facades\Storage;

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

    public function scopeFilter(BaseBuilder|EloquentBuilder $query, array $filters): BaseBuilder|EloquentBuilder
    {
        return $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', "%" . $search . "%")
                    ->orWhere('description', 'like', "%" . $search . "%");
            });  // just searching using text and the where cluse fix the logical operation issue and wont ignore text parameters title and description
        })->when($filters['min_price'] ?? null, function ($query, $minPrice) {
            $query->where('price', '>=', $minPrice);
        })->when($filters['max_price'] ?? null, function ($query, $maxPrice) {
            $query->where('price', '<=', $maxPrice);
        })->when($filters['genre'] ?? null, function ($query, $genre) {
            $query->where('genre', $genre);
        })->when($filters['type'] ?? null, function ($query, $type) {
            $query->where('type', $type);
        })->when($filters['platform'] ?? null, function ($query, $platform) {
            $query->where('platform', $platform);
        });
    }

    public function getImageUrlAttribute(): string
    {
        /** @var Cloud $disk */
        $disk = Storage::disk('s3');

        $key = $this->product_photo_path;

        if (!$key) {
            return asset('assets/images/loginimg.png');
        }

        return $disk->url(ltrim((string) $key, '/'));
    }
}
