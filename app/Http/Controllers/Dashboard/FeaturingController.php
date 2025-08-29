<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeaturingController extends Controller
{

    public function update(Request $request, Product $product)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->isAdmin()) {
            return redirect()->route('home');
        }

        $validated = $request->validate([
            'featured' => ['required', 'boolean'],
        ]);

        $product->featured = (bool) $validated['featured'];
        $product->save();

        return back()->with('success', 'Featured status updated.');
    }
}
