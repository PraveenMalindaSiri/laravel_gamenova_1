<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductsScreenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $filters = request()->only('search', 'min_price', 'max_price', 'type', 'genre', 'platform');
            $products = Product::filter($filters)->orderBy('title', 'asc')->get();

            return ProductResource::collection($products);
        } catch (AuthorizationException | ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function show(String $id)
    {
        try {
            $product = Product::withTrashed()->findOrFail($id);

            $reviews = Review::where('product_id', (string) $product->id)
                ->orderBy('_id', 'desc')->limit(20)->get();

            return response()->json(
                [
                    'data' => ProductResource::make($product),
                    'reviews' => $reviews
                ]
            );
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Product not found.',
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong',
                'error'   => $th->getMessage()
            ], 500);
        }
    }
}
