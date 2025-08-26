<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Product::class);

        /** @var \App\Models\User $user */
        $user = $request->user();

        if ($user->isAdmin()) {
            $products = Product::withTrashed()->latest()->paginate(20);
        } elseif ($user->isSeller()) {
            $products = $user->products()->withTrashed()->latest()->paginate(20);
        } else {
            abort(403);
        }

        return view('dashboard.product.index', [
            'panel'    => $user->role,
            'products' => $products,
        ]);
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
            $data['product_photo_path'] = $this->buildStoredPath($request->file('product_photo'));
        }

        Product::create($data);

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
        $disk = 's3';
        $newPath = null;

        $oldPath = $product->product_photo_path;

        if ($request->hasFile('product_photo')) {
            $newPath = $this->buildStoredPath($request->file('product_photo'), 'products', $disk);
            $data['product_photo_path'] = $newPath;
        }

        $product->update($data);

        if ($newPath && $oldPath && Storage::disk($disk)->exists($oldPath)) {
            Storage::disk($disk)->delete($oldPath);
        }

        return back()->with('success', 'Product updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        Gate::authorize('delete', $product);

        $product->delete();

        return back()->with('success', 'Product deleted');
    }

    protected function buildStoredPath(UploadedFile $file, string $dir = 'products', string $disk = 's3'): string
    {
        $ext      = $file->getClientOriginalExtension();
        $basename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        $safeName  = \Illuminate\Support\Str::slug($basename);
        $timestamp = now()->format('Ymd_His');
        $rand      = \Illuminate\Support\Str::random(6);

        $filename  = "{$safeName}_{$timestamp}_{$rand}.{$ext}";

        return $file->storeAs($dir, $filename, $disk);
    }
}
