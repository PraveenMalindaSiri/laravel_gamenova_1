<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Create Product
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 space-y-6">

                <form action="{{ route('myproducts.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf

                    <div class="mb-4 grid grid-cols-3 gap-4">
                        <div class="col-span-3">
                            {{-- Product Photo --}}
                            <label class="block text-sm font-medium">
                                Product Photo
                                <span class="text-red-600">*</span>
                            </label>
                            <input type="file" name="product_photo" accept="image/*"
                                class="mt-1 block w-full rounded-xl border px-3 py-2">
                            @error('product_photo')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Title --}}
                        <div class="col-span-3">
                            <x-input-field name="title" label="Title" :value="old('title')" required />

                        </div>

                        <div class="col-span-3">
                            {{-- Description --}}
                            <div class="w-full">
                                <label class="mb-1 block text-sm font-medium text-gray-700">
                                    Description <span class="text-red-600">*</span>
                                </label>
                                <textarea name="description" rows="5"
                                    class="block w-full rounded-xl border px-3 py-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('description') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Duration --}}
                        <div>
                            <x-input-field name="duration" label="Duration" placeholder="e.g. 12h 30m" :value="old('duration')"
                                required />
                        </div>

                        {{-- Size (GB) --}}
                        <div>
                            <x-input-field name="size" type="number" step="0.01" label="Size (GB)"
                                :value="old('size')" required />
                        </div>

                        {{-- Age Rating --}}
                        <div>
                            <x-input-field name="age_rating" type="number" label="Age Rating" :value="old('age_rating')"
                                required />
                        </div>

                        {{-- Company --}}
                        <div>
                            <x-input-field name="company" label="Company" :value="old('company')" required />

                        </div>

                        {{-- Price --}}
                        <div>
                            <x-input-field name="price" type="number" step="0.01" label="Price" :value="old('price')"
                                required />
                        </div>

                        {{-- Release Date --}}
                        <div>
                            <x-input-field name="released_date" type="date" label="Release Date" :value="old('released_date')"
                                required />
                        </div>

                        {{-- Type --}}
                        <div class="mt-4">
                            <label class="mb-1 block text-sm font-medium text-gray-700">Type
                                <span class="text-red-600">*</span>
                            </label>
                            <div class="ml-4">
                                <x-radio-group name="type" :allOpt="false" :options="array_combine(
                                    array_map('ucfirst', \App\Models\Product::$type),
                                    \App\Models\Product::$type,
                                )" :value="old('type')" />
                            </div>
                        </div>

                        {{-- Genre --}}
                        <div class="mt-4">
                            <label class="mb-1 block text-sm font-medium text-gray-700">Genres
                                <span class="text-red-600">*</span>
                            </label>
                            <div class="ml-4">
                                <x-radio-group name="genre" :allOpt="false" :options="\App\Models\Product::$genres"
                                    :value="old('genre')" />
                            </div>
                        </div>

                        {{-- Platform --}}
                        <div class="mt-4">
                            <label class="mb-1 block text-sm font-medium text-gray-700">Platform
                                <span class="text-red-600">*</span>
                            </label>
                            <div class="ml-4">
                                <x-radio-group name="platform" :allOpt="false" :options="\App\Models\Product::$platforms"
                                    :value="old('platform')" />
                            </div>
                        </div>
                    </div>

                    <x-button class="ms-4">
                        {{ 'Create' }}
                    </x-button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
