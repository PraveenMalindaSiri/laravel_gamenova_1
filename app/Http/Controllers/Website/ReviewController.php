<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $data = $request->validate([
            'rating'     => ['required', 'integer', 'min:1', 'max:10'],
            'comment'    => ['nullable', 'string', 'max:255'],
        ]);

        $review = Review::updateOrCreate(
            [
                'product_id' => (string)$product->id,
                'user_id' => (string)$request->user()->id
            ],
            [
                'rating' => $data['rating'],
                'comment' => $data['comment']
            ]
        );

        return redirect()->back()->with('success', 'Review stored!!!');
    }

    public function destroy(Product $product, string $id)
    {
        $deleted = Review::where('_id', $id)
            ->where('product_id', (string) $product->id)
            ->where('user_id', (string) Auth::user()->id)
            ->delete();

        return back()->with('success', 'Review Deleted Successfully!!!');
    }
}
