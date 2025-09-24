<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'orderId'    => (int) $this->order_id,
            'productId'  => (int) $this->product_id,
            'quantity'   => (int) $this->quantity,
            'price'      => (float) $this->price,
            'digitalcode' => $this->digitalcode,
            'isDigital'  => (bool)  $this->is_digital,
            'product'    => new ProductResource($this->whenLoaded('product')),
        ];
    }
}
