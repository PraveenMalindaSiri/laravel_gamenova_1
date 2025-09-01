<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->take(5)->get();
        $featured = Product::where('featured', true)->latest()->take(5)->get();

        return view('website.home', ["products" => $products, "featured" => $featured]);
    }
}
