<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService
{
    public function createFromCart(string $userId)
    {
        return DB::transaction(function () use ($userId) {
            $cartItems = Cart::with('product')->where('user_id', $userId)->get();

            if ($cartItems->isEmpty()) {
                throw new \RuntimeException('Cart is empty.');
            }

            $total = $cartItems->sum(fn($ci) => $ci->product->price * $ci->quantity);
            $itemsCount = $cartItems->sum('quantity');

            $order = Order::create([
                'user_id'      => $userId,
                'items_count'  => $itemsCount,
                'totalprice'        => $total,
            ]);

            foreach ($cartItems as $ci) {
                $product = $ci->product;

                $isDigital = $product->type === 'digital';

                $amount = $isDigital ? 1 : $ci->quantity;

                $digitalCode = $isDigital
                    ? sprintf('GN-%d-%d-%s', $order->id, $product->id, Str::random(4))
                    : null;

                OrderItem::create([
                    'order_id'      => $order->id,
                    'product_id'    => $product->id,
                    'price'         => $product->price,
                    'quantity'      => $amount,
                    'is_digital'    => $isDigital,
                    'digitalcode'  => $digitalCode,
                ]);
            }
            Cart::where('user_id', $userId)->delete();

            return $order;
        });
    }
}
