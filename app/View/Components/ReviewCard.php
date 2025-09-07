<?php

namespace App\View\Components;

use App\Models\Review;
use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ReviewCard extends Component
{
    /**
     * Create a new component instance.
     */
    public string $userName;
    
    public function __construct(
        public Review $review,
    ) {
        $this->userName = User::find($review->user_id)?->name ?? 'Anonymous';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.review-card');
    }
}
