<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl"> {{ $mode === 'edit' ? 'Edit Product' : 'Create Product' }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <form
                    action="{{ $mode === 'edit' ? route('seller.products.update', $product) : route('seller.products.store') }}"
                    method="POST" enctype="multipart/form-data">

                    @csrf
                    @if ($mode === 'edit')
                        @method('PUT')
                    @endif

                    <div>
                        <label class="block text-sm font-medium">
                            Product Photo {{ $mode === 'create' ? '(required)' : '(optional)' }}
                        </label>
                        <input type="file" name="product_photo" wire:model="product_photo" accept="image/*"
                            class="mt-1 block w-full rounded-xl border px-3 py-2">
                        @error('product_photo')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        <div wire:loading wire:target="product_photo" class="text-xs text-gray-500 mt-1">Uploading…
                        </div>

                        @if ($product_photo)
                            <img src="" class="mt-2 h-24 rounded-lg object-cover">
                        @elseif($mode === 'edit' && $product?->product_photo_path)
                            <img src="{{ Storage::disk('s3')->url($product->product_photo_path) }}"
                                class="mt-2 h-24 rounded-lg object-cover">
                        @endif
                    </div>

                    {{-- Title --}}
                    <x-input-field name="title" label="Title" wire:model.blur="title" :value="$title" required />

                    {{-- Description --}}
                    <div class="w-full">
                        <label class="mb-1 block text-sm font-medium text-gray-700">Description <span
                                class="text-red-600">*</span></label>
                        <textarea name="description" rows="5" wire:model.blur="description"
                            class="block w-full rounded-xl border px-3 py-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('description') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">{{ old('description', $description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Duration --}}
                    <x-input-field name="duration" label="Duration" placeholder="e.g. 12h 30m"
                        wire:model.blur="duration" :value="$duration" required />

                    {{-- Company --}}
                    <x-input-field name="company" label="Company" wire:model.blur="company" :value="$company"
                        required />

                    {{-- Price --}}
                    <x-input-field name="price" type="number" step="0.01" label="Price" wire:model.blur="price"
                        :value="$price" required />

                    {{-- Release Date --}}
                    <x-input-field name="released_date" type="date" label="Release Date"
                        wire:model.blur="released_date" :value="$released_date" required />

                    {{-- Size (GB) --}}
                    <x-input-field name="size" type="number" step="0.01" label="Size (GB)" wire:model.blur="size"
                        :value="$size" required />

                    {{-- Age Rating --}}
                    <x-input-field name="age_rating" type="number" label="Age Rating" wire:model.blur="age_rating"
                        :value="$age_rating" required />

                    <div class="mt-4">
                        <label for="type" class="mb-1 block text-sm font-medium text-gray-700">Type</label>
                        <div class="ml-4">
                            <x-radio-group name="type" :allOpt="false" :options="array_combine(
                                array_map('ucfirst', \App\Models\Product::$type),
                                \App\Models\Product::$type,
                            )" :value="old('type')" />
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="genre" class="mb-1 block text-sm font-medium text-gray-700">Genres</label>
                        <div class="ml-4">
                            <x-radio-group name="genre" :allOpt="false" :options="\App\Models\Product::$genres" :value="old('genre')" />
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="platform" class="mb-1 block text-sm font-medium text-gray-700">Platform</label>
                        <div class="ml-4">
                            <x-radio-group name="platform" :allOpt="false" :options="\App\Models\Product::$platforms" :value="old('platform')" />
                        </div>
                    </div>

                    <x-button class="ms-4">
                        {{ $mode == 'create' ? 'Create' : 'Edit' }}
                    </x-button>
                </form>

            </div>
        </div>
    </div>

</x-app-layout>
