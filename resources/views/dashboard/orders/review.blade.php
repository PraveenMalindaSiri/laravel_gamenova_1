<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            {{ 'Order Items Review - ' }} {{ $product->title }}
        </h2>
    </x-slot>

    <div class="mt-10">
        <div class="bg-white overflow-hidden shadow-xl p-6 mx-56 rounded-lg">
            {{-- add review --}}
            <form method="POST" action="{{ route('reviews.store', $product) }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <x-input-field name="rating" type="number" label="Rating" min="1" max="10"
                    value="{{ old('rating', optional($userReview)->rating) }}" />

                <x-input-field name="comment" label="Comment"
                    value="{{ old('comment', optional($userReview)->comment) }}" />

                <x-button class="m-4">
                    {{ $userReview ? 'Update Review' : 'Add Review' }}
                </x-button>
            </form>

            {{-- delete review --}}
            @if ($userReview)
                <form method="POST"
                    action="{{ route('reviews.delete', ['product' => $product->id, 'id' => (string) $userReview->_id]) }}"
                    onsubmit="return confirm('Delete your review?');" class="ml-4">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-1 rounded-md hover:bg-red-700">
                        Delete Review
                    </button>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>
