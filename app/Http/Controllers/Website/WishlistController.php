<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wishlists = Wishlist::with('product')
            ->where('user_id', Auth::id())
            ->get();

        return view('website.customer.wishlist', ['wishlists' => $wishlists]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = Product::findOrFail($request->input('product_id'));

        $isDigital = $product->type === "digital";

        $exsist = Wishlist::where('product_id', $product->id)->exists();

        if ($exsist) {
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $wishlist = Wishlist::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $wishlist->delete();

        return back()->with('success', 'Item removed from wishlist.');
    }
}
