<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WishlistResource;
use App\Models\Product;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wishlist = Wishlist::with('product')
            ->where('user_id', Auth::user()->id)
            ->get();

        return WishlistResource::collection($wishlist)->response()
            ->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $product = Product::findOrFail($request->input('product_id'));

            $age = Carbon::parse(Auth::user()->dob)->age;

            if ($age < (int) $product->age_rating) {
                return response()->json([
                    'message' => 'You are not old enough to purchase this product.'
                ], 403);
            }

            $isDigital = $product->type === "digital";

            $exists = Wishlist::where('user_id', Auth::user()->id)
                ->where('product_id', $product->id)
                ->exists();

            if ($exists) {
                return response()->json([
                    'message' => 'You already have this item in your wishlist'
                ], 403);
            }

            $rules = ['quantity' => ['required', 'integer', 'min:1']];
            $rules['quantity'][] = $isDigital ? 'max:1' : 'max:10';
            $validated = $request->validate($rules);

            $qty = (int) $validated['quantity'];
            if ($isDigital) {
                $qty = 1;
            }

            $wishlist = Wishlist::create(
                [
                    'user_id' => Auth::user()->id,
                    'product_id' => $product->id,
                    'quantity' => $qty
                ]
            );

            return response()->json([
                'message' => 'Added to wishlist',
                'data'    => [
                    'id'         => $wishlist->id,
                    'product_id' => $wishlist->product_id,
                    'quantity'   => $wishlist->quantity,
                ],
            ], 201);
        } catch (AuthorizationException | ValidationException $e) {
            throw $e;
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed to add the game to wishlist',
                'error'   => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $wishlist = Wishlist::with('product')
                ->where('id', $id)
                ->where('user_id', Auth::user()->id)
                ->firstOrFail();

            $isDigital = $wishlist->product->type === 'digital';

            $rules = ['quantity' => ['required', 'integer', 'min:1']];
            $rules['quantity'][] = $isDigital ? 'max:1' : 'max:10';

            $validated = $request->validate($rules);

            $qty = (int) $validated['quantity'];
            if ($isDigital) {
                $qty = 1;
            }

            if ($qty === $wishlist->quantity) {
                return response()->json([
                    'message' => "No changes were made to '{$wishlist->product?->title}'."
                ], 200);
            }

            $wishlist->update(['quantity' => $qty]);

            return response()->json([
                'message' => 'Wishlist updated',
                'data'    => [
                    'id'         => $wishlist->id,
                    'product_id' => $wishlist->product_id,
                    'quantity'   => $wishlist->quantity,
                ],
            ], 200);
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
    public function destroy(string $id)
    {
        try {
            $wishlist = Wishlist::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $wishlist->delete();

            return response()->json(['message' => 'Item deleted from the wishlist'], 200);
        } catch (AuthorizationException | ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
