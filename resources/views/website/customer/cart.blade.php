<x-layout>
    @forelse ($carts as $cart)
        <x-game-card :product="$cart->product" :games="false" :fromCart="true" cartAmount="{{ $cart->quantity }}"
            cartItemID="{{ $cart->id }}" />
    @empty
        <div class="text-sm font-semibold text-center my-64">
            No Cart Items!!!
        </div>
    @endforelse
</x-layout>
