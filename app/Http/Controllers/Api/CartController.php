<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResourec;
use App\Models\Cart;
use App\Models\Product;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $carts = Cart::with('product')
            ->where('user_id', Auth::user()->id)
            ->get();

        return CartResourec::collection($carts)->response()
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

            $exists = Cart::where('user_id', Auth::user()->id)
                ->where('product_id', $product->id)
                ->exists();

            if ($exists) {
                return response()->json([
                    'message' => 'You already have this item in your cart'
                ], 403);
            }

            $rules = ['quantity' => ['required', 'integer', 'min:1']];
            $rules['quantity'][] = $isDigital ? 'max:1' : 'max:10';
            $validated = $request->validate($rules);

            $qty = (int) $validated['quantity'];
            if ($isDigital) {
                $qty = 1;
            }

            $cart = Cart::create(
                [
                    'user_id' => Auth::user()->id,
                    'product_id' => $product->id,
                    'quantity' => $qty
                ]
            );

            $cart->load('product');

            return CartResourec::make($cart)
                ->additional(['message' => 'Added to Cart'])
                ->response()
                ->setStatusCode(200);
        } catch (AuthorizationException | ValidationException $e) {
            throw $e;
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed to add the game to cart',
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
            $cart = Cart::with('product')
                ->where('id', $id)
                ->where('user_id', Auth::user()->id)
                ->firstOrFail();

            $isDigital = $cart->product->type === 'digital';

            $rules = ['quantity' => ['required', 'integer', 'min:1']];
            $rules['quantity'][] = $isDigital ? 'max:1' : 'max:10';

            $validated = $request->validate($rules);

            $qty = (int) $validated['quantity'];
            if ($isDigital) {
                $qty = 1;
            }

            if ($qty === $cart->quantity) {
                return response()->json([
                    'message' => "No changes were made to '{$cart->product?->title}'."
                ], 200);
            }

            $cart->update(['quantity' => $qty]);
            $cart->load('product');

            return CartResourec::make($cart)
                ->additional(['message' => 'Wishlist updated'])
                ->response()
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
    public function destroy(string $id)
    {
        try {
            $cart = Cart::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $cart->delete();

            return response()->json(['message' => 'Item deleted from the cart'], 200);
        } catch (AuthorizationException | ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function payment(Request $request, OrderService $orderService)
    {

        try {
            $order = $orderService->createFromCart(Auth::user()->id);

            return response()->json([
                'message' => 'Order created successfully',
                'order_id' => $order->id,
            ], 201);
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
