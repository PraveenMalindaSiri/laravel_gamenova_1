<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $totalPrice = $carts->sum(fn($c) => (float)$c->product->price * (int)$c->quantity);
        $games = $carts->count();
        $items = (int) $carts->sum('quantity');

        return view('website.customer.cart', ['carts' => $carts, 'totalPrice' => $totalPrice, 'games' => $games, 'items' => $items]);
    }

    public function store(Request $request)
    {
        $product = Product::findOrFail($request->input('product_id'));

        $age = Carbon::parse(Auth::user()->dob)->age;

        if ($age < (int) $product->age_rating) {
            return redirect()->back()->with('error', 'You are not old enough to purchase this product.');
        }

        $isDigital = $product->type === "digital";

        $exists = Cart::where('user_id', Auth::user()->id)
            ->where('product_id', $product->id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', "You already have this item in your cart");
        }

        $rules = ['quantity' => ['required', 'integer', 'min:1']];
        $rules['quantity'][] = $isDigital ? 'max:1' : 'max:10';
        $validated = $request->validate($rules);

        $qty = (int) $validated['quantity'];
        if ($isDigital) {
            $qty = 1;
        }

        Cart::create(
            [
                'user_id' => Auth::user()->id,
                'product_id' => $product->id,
                'quantity' => $qty
            ]
        );

        return redirect()->back()->with('success', "Added '{$product->title}' x {$qty} to the Cart.");
    }

    public function update(Request $request, string $id)
    {
        $cart = Cart::with('product')
            ->where('id', $id)
            ->where('user_id', Auth::user()->id)
            ->firstOrFail();

        $isDigital = $cart->product->type === 'digital';

        $rules = ['quantity' => ['required', 'integer', 'min:1']];
        $rules['quantity'][] = $isDigital ? 'max:1' : 'max:10';

        $validated = $request->validate($rules);

        $qty = (int) $validated['quantity'];
        if ($isDigital) {
            $qty = 1;
        }

        if ($qty === $cart->quantity) {
            return back()->with('info', "No changes were made to '{$cart->product->title}'.");
        }

        $cart->update(['quantity' => $qty]);

        return back()->with('success', "Updated '{$cart->product->title}' to x{$qty} in your cart.");
    }

    public function destroy(string $id)
    {
        $cart = Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $cart->delete();

        return back()->with('success', 'Item removed from the Cart.');
    }
}
