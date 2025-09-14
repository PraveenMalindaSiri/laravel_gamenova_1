<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class FeaturingController extends Controller
{

    public function update(Request $request, Product $product)
    {
        Gate::authorize('access-admin');

        $validated = $request->validate([
            'featured' => ['required', 'boolean'],
        ]);

        $product->featured = (bool) $validated['featured'];
        $product->save();

        return back()->with('success', 'Featured status updated.');
    }
}
