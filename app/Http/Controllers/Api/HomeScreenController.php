<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeScreenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $latest = Product::latest()->take(5)->get();
        $featured = Product::where('featured', true)->latest()->take(5)->get();

        return response()->json([
            'latest'   => ProductResource::collection($latest),
            'featured' => ProductResource::collection($featured),
        ]);
    }
}
