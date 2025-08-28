<x-layout>
    @forelse ($wishlists as $wishlist)
        <x-game-card :product="$wishlist->product" />
    @empty
        <div class="text-sm font-semibold text-center my-64">
            No Wishlist Items!!!
        </div>
    @endforelse
</x-layout>
