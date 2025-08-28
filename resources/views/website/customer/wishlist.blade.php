<x-layout>
    @forelse ($wishlists as $wishlist)
        <x-game-card :product="$wishlist->product" :fromWishlist="true" :games="false" wishlistAmount="{{ $wishlist->quantity }}"
            wishlistItemID="{{ $wishlist->id }}" />
    @empty
        <div class="text-sm font-semibold text-center my-64">
            No Wishlist Items!!!
        </div>
    @endforelse
</x-layout>
