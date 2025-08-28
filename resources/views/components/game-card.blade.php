<div class="rounded-md border border-black p-5 shadow-lg mb-5">
    <div class="grid grid-cols-7 items-center gap-6">
        <div class="col-span-2">
            <img src="{{ asset('assets/images/loginimg.png') }}" alt="{{ $product->title }}"
                class="w-68 h-48 object-cover rounded-md shadow">

            {{-- <img src="{{ $product->image_url }}"
                 alt="{{ $product->title }}"
                 class="w-68 h-48 object-cover rounded-md shadow"> --}}
        </div>

        <div class="text-sm font-semibold">
            <a href="{{ route('product.show', $product) }}" class="hover:text-blue-600">
                {{ ucwords($product->title) }}
            </a>
        </div>

        <div class="text-sm font-semibold text-slate-600">
            {{ ucfirst($product->type) }} Edition
        </div>

        <div class="text-sm font-semibold text-slate-600">
            For {{ $product->platform }}
        </div>

        @if ($games || $fromWishlist)
            <div class="text-sm font-semibold text-blue-600">
                Rs.{{ $product->price }}
            </div>
        @endif

        @if ($fromCart)
            <div class="text-sm font-semibold text-blue-600">
                Rs.{{ $product->price * $cartAmount }}
            </div>
        @endif

        @if ($games)
            <div class="text-xm font-semibold">
                <a href="{{ route('product.show', $product) }}" class="hover:text-blue-600">
                    See more ›
                </a>
            </div>
        @endif

        @if ($fromWishlist)
            <div class="flex flex-col items-center space-y-5">
                <div class="text-sm font-semibold text-slate-600">
                    x {{ $wishlistAmount }} {{ Str::plural('item', $wishlistAmount) }}
                </div>

                {{-- add to CART --}}
                <div>
                    <form action="{{ route('cart.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="quantity" value="{{ $wishlistAmount }}">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <x-button>Add to cart</x-button>
                    </form>
                </div>

                {{-- Remover from wishlist --}}
                <div>
                    <form action="{{ route('wishlist.destroy', $wishlistItemID) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <x-button>Remove</x-button>
                    </form>
                </div>
            </div>
        @endif

        @if ($fromCart)
            <div class="flex flex-col items-center space-y-5">
                {{-- move back to WISHLIST --}}
                <div>
                    <form action="{{ route('wishlist.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="{{ $wishlistAmount }}">
                        <x-button>Add to Wishlist</x-button>
                    </form>
                </div>

                {{-- Remover from cart --}}
                <div>
                    <form action="{{ route('cart.destroy', $cartItemID) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <x-button>Remove</x-button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
