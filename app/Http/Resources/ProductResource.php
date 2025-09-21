<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use PhpParser\Node\Expr\Cast\Double;
use Ramsey\Uuid\Type\Decimal;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'title'       => ucwords($this->title),
            'type'        => ucfirst($this->type),
            'genre'       => ucfirst($this->genre),
            'platform'    => ucfirst($this->platform),
            'price'       => (float) $this->price,
            'company'     => $this->company,
            'released_date' => $this->released_date?->format('Y-m-d'),
            'size'        => (float) $this->size,
            'duration'    => $this->duration,
            'age_rating'  => (int) $this->age_rating,
            'description' => $this->description,
            'image_url'   => $this->product_photo_path,
            'seller_id'   => $this->seller_id,
            'created_at'  => $this->created_at->toDateString(),
            'deleted_at' => $this->deleted_at?->toDateString(),
            'featured' => (bool) $this->featured
        ];
    }
}
