<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Product::class);

        return view(
            'dashboard.product.index',
            ['panel' => Auth::user()->role]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Product::class);

        return view('dashboard.seller.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        Gate::authorize('create', Product::class);

        $data = $request->validated();
        $data['seller_id'] = Auth::user()->id;

        if ($request->hasFile('product_photo')) {
            $data['product_photo_path'] = $request->file('product_photo')->store('products', 's3'); // or 'public'
        }

        return back()->with('success', 'Product created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        Gate::authorize('update', $product);
        return view('dashboard.product.edit', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        Gate::authorize('update', $product);

        $data = $request->validated();

        if ($request->hasFile('product_photo')) {
            $data['product_photo_path'] = $request->file('product_photo')->store('products', 's3');
        }

        $product->update($data);

        return back()->with('success', 'Product updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        Gate::authorize('delete', $product);
    }
}
