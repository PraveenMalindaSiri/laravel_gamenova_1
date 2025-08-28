<?php

namespace App\View\Components;

use App\Models\CustomerCart;
use App\Models\Product;
use App\Models\Wishlist;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GameCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Product $product,
        public ?string $wishlistItemID = null,
        public ?string $cartItemID = null,
        public ?int $wishlistAmount = 1,
        public ?int $cartAmount = 1,
        public ?bool $games = true,
        public ?bool $fromWishlist = false,
        public ?bool $fromCart = false,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.game-card');
    }
}
