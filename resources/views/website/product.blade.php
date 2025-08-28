<x-layout>
    <div class="rounded-md border border-black p-5 shadow-lg mb-10">
        <form action="{{ route('product.index') }}" method="GET">
            <div class="mb-4 grid grid-cols-3 gap-4">

                <div class="mb-4 col-span-2">
                    <div>Search</div>
                    <x-input-field name="search" value="{{ request('search') }}" placeholder="Seach for any input" />
                </div>

                <div class="mb-4">
                    <div>Price</div>
                    <div class="flex space-x-2">
                        <x-input-field name="min_price" value="{{ request('min_price') }}" placeholder="From" />
                        <x-input-field name="max_price" value="{{ request('max_price') }}" placeholder="To" />
                    </div>
                </div>


                <div>
                    <div>Edition</div>
                    <div>
                        <x-radio-group name="type" :options="array_combine(
                            array_map('ucfirst', \App\Models\Product::$type),
                            \App\Models\Product::$type,
                        )" />
                    </div>
                </div>
                <div>
                    <div>Genre</div>
                    <div>
                        <x-radio-group name="genre" :options="\App\Models\Product::$genres" />
                    </div>
                </div>
                <div>
                    <div>Platform</div>
                    <div>
                        <x-radio-group name="platform" :options="\App\Models\Product::$platforms" />
                    </div>
                </div>
            </div>
            <x-button>
                {{ 'Search' }}
            </x-button>
        </form>
    </div>

    @forelse ($products as $product)
        <x-game-card :product="$product" />
    @empty
        <div class="text-sm font-semibold text-center mb-5">
            No Games!!!
        </div>
    @endforelse

</x-layout>
