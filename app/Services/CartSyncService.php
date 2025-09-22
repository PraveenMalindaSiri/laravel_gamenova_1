<?php

namespace App\Services;

use App\Models\Cart;
use Illuminate\Support\Facades\DB;

class CartSyncService
{
    public function syncing(string $uid, array $data)
    {
        return DB::transaction(function () use ($uid, $data) {
            Cart::where('user_id', $uid)->delete();

            foreach ($data as $key => $value) {
                Cart::insert([
                    'user_id' => (int) $uid,
                    'product_id' => (int) $key,
                    'quantity' => (int) $value,
                ]);
            }
        });
    }
}
