<div class="w-full rounded-lg border border-slate-200 bg-white p-4 shadow-sm my-3">
    <div class="text-md font-semibold text-slate-900 mb-2">
        Name: {{ $userName }}
    </div>
    <div class="flex items-center justify-between mb-2">
        <div class="text-sm font-semibold text-slate-600">
            Rating: {{ $review->rating }}/10
        </div>
        <div class="text-xs text-slate-500">
            {{ $review->created_at?->diffForHumans() }}
        </div>
    </div>

    <p class="text-sm text-slate-700">
        {{ $review->comment ?: 'No comment provided.' }}
    </p>
</div>
