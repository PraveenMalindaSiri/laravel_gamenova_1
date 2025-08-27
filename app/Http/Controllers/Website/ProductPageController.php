<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductPageController extends Controller
{
    public function index()
    {
        $filters = request()->only('search', 'min_price', 'max_price', 'type', 'genre', 'platform');

        return view('website.product', ['products' => Product::filter($filters)->paginate(15)->withQueryString()]);
    }

    public function show(Product $product)
    {
        return view('website.details', ['product' => $product]);
    }
}
