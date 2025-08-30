<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::with('product')
            ->where('user_id', Auth::user()->id)
            ->get();

        return view('website.customer.wishlist', ['wishlists' => $wishlists]);
    }

    public function store(Request $request)
    {
        $product = Product::findOrFail($request->input('product_id'));

        $age = Carbon::parse(Auth::user()->dob)->age;

        if ($age < (int) $product->age_rating) {
            return redirect()->back()->with('error', 'You are not old enough to purchase this product.');
        }

        $isDigital = $product->type === "digital";

        $exists = Wishlist::where('user_id', Auth::user()->id)
            ->where('product_id', $product->id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', "You already have this item in your wishlist");
        }

        $rules = ['quantity' => ['required', 'integer', 'min:1']];
        $rules['quantity'][] = $isDigital ? 'max:1' : 'max:10';
        $validated = $request->validate($rules);

        $qty = (int) $validated['quantity'];
        if ($isDigital) {
            $qty = 1;
        }

        Wishlist::create(
            [
                'user_id' => Auth::user()->id,
                'product_id' => $product->id,
                'quantity' => $qty
            ]
        );

        return redirect()->back()->with('success', "Added the {$product->title} x {$qty} to the wishlist.");
    }

    public function update(Request $request, string $id)
    {
        $wishlist = Wishlist::with('product')
            ->where('id', $id)
            ->where('user_id', Auth::user()->id)
            ->firstOrFail();

        $isDigital = $wishlist->product->type === 'digital';

        $rules = ['quantity' => ['required', 'integer', 'min:1']];
        $rules['quantity'][] = $isDigital ? 'max:1' : 'max:10';

        $validated = $request->validate($rules);

        $qty = (int) $validated['quantity'];
        if ($isDigital) {
            $qty = 1;
        }

        if ($qty === $wishlist->quantity) {
            return back()->with('info', "No changes were made to '{$wishlist->product->title}'.");
        }

        $wishlist->update(['quantity' => $qty]);

        return back()->with('success', "Updated '{$wishlist->product->title}' to x{$qty} in your wishlist.");
    }


    public function destroy(string $id)
    {
        $wishlist = Wishlist::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $wishlist->delete();

        return back()->with('success', 'Item removed from wishlist.');
    }
}
