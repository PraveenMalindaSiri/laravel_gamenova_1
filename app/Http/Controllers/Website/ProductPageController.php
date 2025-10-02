<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductPageController extends Controller
{
    public function index()
    {
        $filters = request()->only('search', 'min_price', 'max_price', 'type', 'genre', 'platform');

        return view('website.product', ['products' => Product::filter($filters)->paginate(15)->withQueryString()]);
    }

    public function show(String $id)
    {
        $product = Product::withTrashed()->findOrFail($id);

        $reviews = Review::where('product_id', (string) $product->id)
            ->orderBy('_id', 'desc')->limit(20)->get();

        return view('website.details', ['product' => $product, 'reviews' => $reviews]);
    }
}
