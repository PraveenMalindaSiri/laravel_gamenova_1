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

        <div class="text-sm font-semibold text-blue-600">
            Rs.{{ $product->price }}
        </div>

        <div class="text-xm font-semibold">
            <a href="{{ route('product.show', $product) }}" class="hover:text-blue-600">
                See more ›
            </a>
        </div>
    </div>
</div>
