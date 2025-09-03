<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\ProductRevenue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RevenueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        $base = ProductRevenue::with([
            'product' => fn($q) => $q->withTrashed(),
            'seller',
        ])->latest();

        if ($user->isAdmin()) {
            $revenues = $base->paginate(15);
        } elseif ($user->isSeller()) {
            $revenues = $base->where('seller_id', $user->id)->paginate(15);
        } else {
            abort(403);
        }

        return view('dashboard.seller.index', [
            'revenues' => $revenues,
        ]);
    }
}
