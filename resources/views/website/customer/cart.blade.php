<x-layout>
    @forelse ($products as $product)
        <x-game-card :product="$product" />
    @empty
        <div class="text-sm font-semibold text-center my-64">
            No Cart Items!!!
        </div>
    @endforelse
</x-layout>
