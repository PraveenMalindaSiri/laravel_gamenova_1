<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if ($user?->isAdmin()) {
            $orders = Order::with('user')->get();
        } elseif ($user?->isCustomer()) {
            $orders = Order::with('user')
                ->where('user_id', $user->id)
                ->get();
        } else {
            $orders = collect(); // e.g. seller or unknown role
        }

        return view('dashboard.orders.index', [
            'panel'  => $user?->role,
            'orders' => $orders,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (! $user->isAdmin() && $order->user_id !== $user->id) {
            abort(403, "You are not allowed to view this order.");
        }

        // via relation (recommended)
        $orderItems = $order->items()->with('product')->get();

        return view('dashboard.orders.show', [
            'orderItems' => $orderItems,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
