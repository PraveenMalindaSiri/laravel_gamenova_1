<x-layout>

    <div class="container mx-auto p-4 border-y border-slate-400">
        <div class="flex flex-col gap-8 lg:flex-row">

            {{-- IMAGE --}}

            <div class="w-full lg:w-1/2">
                <img src="{{ asset('assets/images/loginimg.png') }}" alt="{{ $product->title }}"
                    class="w-full aspect-video object-cover rounded-xl shadow">

                {{-- <img src="{{ $product->image_url }}"
                 alt="{{ $product->title }}"
                 class="w-full aspect-video object-cover rounded-xl shadow"> --}}
            </div>

            {{-- DETAILS --}}
            <div class="flex w-full flex-col gap-6 lg:w-1/2">
                <div class="text-3xl font-semibold leading-tight">{{ $product->title }}</div>

                <p class="text-slate-700">{{ $product->description }}</p>


                <div class="flex flex-wrap gap-2">
                    <span class="rounded-full bg-slate-400 px-3 py-1 text-xm font-medium text-slate-700">
                        {{ ucwords($product->type) }} Edition
                    </span>
                    <span class="rounded-full bg-slate-400 px-3 py-1 text-xm font-medium text-slate-700">
                        {{ $product->genre }}
                    </span>
                    <span class="rounded-full bg-slate-400 px-3 py-1 text-xm font-medium text-slate-700">
                        {{ $product->platform }}
                    </span>
                    <span class="rounded-full bg-slate-400 px-3 py-1 text-xm font-medium text-slate-700">
                        {{ $product->age_rating }}
                    </span>
                </div>

                {{-- Meta grid --}}
                <div class="grid grid-cols-2 gap-4 text-sm text-slate-700 sm:grid-cols-3">
                    <div>
                        <div class="font-medium text-slate-900">Duration</div>
                        <div>{{ $product->duration }}</div>
                    </div>
                    <div>
                        <div class="font-medium text-slate-900">Company</div>
                        <div>{{ $product->company }}</div>
                    </div>
                    <div>
                        <div class="font-medium text-slate-900">Size</div>
                        <div>{{ $product->size }} GB</div>
                    </div>
                    <div class="sm:col-span-2">
                        <div class="font-medium text-slate-900">Release Date</div>
                        <div>{{ $product->released_date->format('M d, Y') }}</div>
                    </div>
                </div>

                <div class="text-2xl font-semibold">Rs. {{ $product->price }}</div>

                {{-- Actions --}}
                <div class="flex flex-wrap items-end gap-3">
                    <form action="" method="POST" class="flex items-end gap-3">
                        @csrf
                        <div class="w-28">
                            <x-input-field name="quantity" type="number" label="Quantity" min="1" step="1"
                                value="1" />
                        </div>
                        <x-button type="submit">Add to Cart</x-button>
                    </form>

                    <form action="" method="POST">
                        @csrf
                        <x-button type="submit" variant="secondary">Add to Wishlist</x-button>
                    </form>
                </div>

            </div>
        </div>
    </div>

</x-layout>
