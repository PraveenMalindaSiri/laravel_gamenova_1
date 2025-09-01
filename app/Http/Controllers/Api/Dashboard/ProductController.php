<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Product::class);

        /** @var \App\Models\User $user */
        $user = $request->user();

        if ($user->isAdmin()) {
            $products = Product::withTrashed()->latest()->paginate(20)->withQueryString();
        } elseif ($user->isSeller()) {
            $products = $user->products()->withTrashed()->latest()->paginate(20)->withQueryString();
        } else {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return ProductResource::collection($products)
            ->additional(['panel' => $user->role])
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        try {
            Gate::authorize('create', Product::class);

            $data = $request->validated();
            $data['seller_id'] = Auth::user()->id;

            if ($request->hasFile('product_photo')) {
                $data['product_photo_path'] = $this->buildStoredPath($request->file('product_photo'));
            }

            $product = Product::create($data);

            return (new ProductResource($product))
                ->additional(['message' => 'Product created'])
                ->response()
                ->setStatusCode(201);
        } catch (AuthorizationException | ValidationException $e) {
            throw $e;
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed to create product',
                'error'   => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            Gate::authorize('update', $product);
            if ($product->trashed()) {
                return response()->json([
                    'message' => "Can't update a deleted item",
                ], 403);
            }

            $data   = $request->validated();
            $disk   = 's3';
            $old    = $product->product_photo_path;
            $new    = null;

            if ($request->hasFile('product_photo')) {
                $new = $this->buildStoredPath($request->file('product_photo'), 'products', $disk);
                $data['product_photo_path'] = $new;
            }

            $product->update($data);

            if ($new && $old && Storage::disk($disk)->exists($old)) {
                Storage::disk($disk)->delete($old);
            }

            return (new ProductResource($product->refresh()))
                ->additional(['message' => 'Product updated'])->response()
                ->setStatusCode(200);
        } catch (AuthorizationException | ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            Gate::authorize('delete', $product);

            $product->delete();

            return response()->json(['message' => 'Product deleted'], 200);
        } catch (AuthorizationException | ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function restore(string $product)
    {
        try {
            $product = Product::withTrashed()->findOrFail($product);
            Gate::authorize('restore', $product);

            if ($product->trashed()) {
                $product->restore();
            } else {
                return response()->json(['message' => 'Not a deleted product'], 403);
            }

            return (new ProductResource($product))
                ->additional(['message' => 'Product restored'])
                ->response()
                ->setStatusCode(200);
        } catch (AuthorizationException | ValidationException $e) {
            throw $e;
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong',
                'error'   => $th->getMessage()
            ], 500);
        }
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
