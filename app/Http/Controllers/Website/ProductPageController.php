<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductPageController extends Controller
{
    public function index()
    {
        return view('website.product');
    }

    public function show(Product $product)
    {
        //
    }
}
