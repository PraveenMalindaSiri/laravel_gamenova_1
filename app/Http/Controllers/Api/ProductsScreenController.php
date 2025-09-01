<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsScreenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filters = request()->only('search', 'min_price', 'max_price', 'type', 'genre', 'platform');
        $products = Product::filter($filters)->paginate(15)->withQueryString();

        return ProductResource::collection($products);
    }
}
