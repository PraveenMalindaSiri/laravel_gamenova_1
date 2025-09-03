<div
    class="rounded-2xl border border-slate-800/20 p-6 shadow-2xl mb-8 bg-gradient-to-br from-slate-900 via-slate-700 to-slate-900 hover:shadow-cyan-500/25 transition-all duration-500 transform hover:-translate-y-1 overflow-hidden">
    <div class="grid grid-cols-7 items-center gap-6">
        <div class="col-span-2">
            <img src="{{ asset('assets/images/loginimg.png') }}" alt="{{ $product->title }}"
                class="w-68 h-48 object-cover rounded-md shadow border-2 border-slate-400">

            {{-- <img src="{{ $product->image_url }}"
                 alt="{{ $product->title }}"
                 class="w-68 h-48 object-cover rounded-md shadow border-2 border-slate-400"> --}}
        </div>

        <div class="text-sm font-semibold">
            <a href="{{ route('product.show', $product) }}"
                class="hover:text-blue-600 text-white hover:underline transition-all duration-300">
                {{ ucwords($product->title) }}
            </a>
        </div>

        <div
            class="text-center px-3 py-2 rounded-full text-sm font-semibold bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg hover:shadow-purple-500/50 transition-all duration-300">
            {{ ucfirst($product->type) }} Edition
        </div>

        <div
            class="text-center px-4 py-2 rounded-full text-sm font-semibold bg-gradient-to-r from-blue-600 to-cyan-600 text-white shadow-lg hover:shadow-blue-500/50 transition-all duration-300">
            For {{ $product->platform }}
        </div>

        @if ($games || $fromWishlist)
            <div class="text-md font-semibold text-blue-400">
                Rs.{{ $product->price }}
            </div>
        @endif

        @if ($fromCart)
            <div class="text-md font-semibold text-blue-400">
                Rs.{{ number_format($product->price * $cartAmount) }}
            </div>
        @endif

        @if ($games)
            <div class="text-xm font-semibold">
                <a href="{{ route('product.show', $product) }}"
                    class="hover:text-white p-2 bg-slate-400 rounded-md hover:bg-slate-700 transition-all duration-300">
                    See more ›
                </a>
            </div>
        @endif

        @if ($fromWishlist)
            <div class="flex flex-col items-center space-y-5">
                <div class="text-sm font-semibold text-slate-300">
                    x {{ $wishlistAmount }} {{ Str::plural('item', $wishlistAmount) }}
                </div>

                @if ($product->type != 'digital')
                    <form action="{{ route('wishlist.update', $wishlistItemID) }}" method="POST"
                        class="flex items-center space-x-2">
                        @csrf
                        @method('PATCH')

                        <input type="number" name="quantity" value="{{ $wishlistAmount }}" min="1"
                            max="{{ $product->type === 'digital' ? 1 : 10 }}"
                            class="w-10 rounded-md border px-2 py-1 text-sm">

                        <x-button class="bg-slate-600">Update</x-button>
                    </form>
                @endif

                {{-- add to CART --}}
                <div>
                    <form action="{{ route('cart.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="quantity" value="{{ $wishlistAmount }}">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <x-button class="bg-slate-600">Add to cart</x-button>
                    </form>
                </div>

                {{-- Remover from wishlist --}}
                <div>
                    <form action="{{ route('wishlist.destroy', $wishlistItemID) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <x-button class="bg-slate-600">Remove</x-button>
                    </form>
                </div>
            </div>
        @endif

        @if ($fromCart)
            <div class="flex flex-col items-center space-y-5">
                @if ($product->type != 'digital')
                    <form action="{{ route('cart.update', $cartItemID) }}" method="POST"
                        class="flex items-center space-x-2">
                        @csrf
                        @method('PATCH')

                        <input type="number" name="quantity" value="{{ $cartAmount }}" min="1"
                            max="{{ $product->type === 'digital' ? 1 : 10 }}"
                            class="w-10 rounded-md border px-2 py-1 text-sm">

                        <x-button class="bg-slate-600">Update</x-button>
                    </form>
                @endif

                {{-- move back to WISHLIST --}}
                <div>
                    <form action="{{ route('wishlist.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="{{ $cartAmount }}">
                        <x-button class="bg-slate-600">Add to Wishlist</x-button>
                    </form>
                </div>

                {{-- Remover from cart --}}
                <div>
                    <form action="{{ route('cart.destroy', $cartItemID) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <x-button class="bg-slate-600">Remove</x-button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
