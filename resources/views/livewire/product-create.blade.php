<form wire:submit.prevent="save" class="space-y-4" novalidate>
    @csrf

    <div class="mb-4 grid grid-cols-3 gap-4">
        <div class="col-span-3">
            {{-- Product Photo --}}
            <label class="block text-sm font-medium">
                Product Photo <span class="text-red-600">*</span>
            </label>

            <input type="file" wire:model.live="product_photo" accept="image/*"
                class="mt-1 block w-full rounded-xl border px-3 py-2">

            <div wire:loading wire:target="product_photo" class="text-xs mt-1 text-gray-500">
                Uploading…
            </div>

            @error('product_photo')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Title --}}
        <div class="col-span-3">
            <x-input-field name="title" label="Title" wire:model.live="title" required />
        </div>

        {{-- Description --}}
        <div class="col-span-3">
            <label class="mb-1 block text-sm font-medium text-gray-700">
                Description <span class="text-red-600">*</span>
            </label>
            <textarea wire:model.live="description" rows="5" class="block w-full rounded-xl border px-3 py-2 shadow-sm"></textarea>
            @error('description')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Duration --}}
        <div>
            <x-input-field name="duration" label="Duration" placeholder="e.g. 12h 30m" wire:model.live="duration" />
        </div>

        {{-- Size (GB) --}}
        <div>
            <x-input-field name="size" type="number" step="0.01" label="Size (GB)" wire:model.live="size"
                required />
        </div>

        {{-- Age Rating --}}
        <div>
            <x-input-field name="age_rating" type="number" label="Age Rating" wire:model.live="age_rating" required />
        </div>

        {{-- Company --}}
        <div>
            <x-input-field name="company" label="Company" wire:model.live="company" />
        </div>

        {{-- Price --}}
        <div>
            <x-input-field name="price" type="number" label="Price" wire:model.live="price" required />
        </div>

        {{-- Release Date --}}
        <div>
            <x-input-field name="released_date" type="date" label="Release Date" wire:model.live="released_date"
                required />
        </div>

        {{-- Type (errors handled inside x-radio-group) --}}
        <div class="mt-4">
            <label class="mb-1 block text-sm font-medium text-gray-700">
                Type <span class="text-red-600">*</span>
            </label>
            <div class="ml-4">
                <x-radio-group name="type" :allOpt="false" :options="array_combine(array_map('ucfirst', \App\Models\Product::$type), \App\Models\Product::$type)" wire:model.live="type" />
            </div>
        </div>

        {{-- Genre --}}
        <div class="mt-4">
            <label class="mb-1 block text-sm font-medium text-gray-700">
                Genres <span class="text-red-600">*</span>
            </label>
            <div class="ml-4">
                <x-radio-group name="genre" :allOpt="false" :options="\App\Models\Product::$genres" wire:model.live="genre" />
            </div>
        </div>

        {{-- Platform --}}
        <div class="mt-4">
            <label class="mb-1 block text-sm font-medium text-gray-700">
                Platform <span class="text-red-600">*</span>
            </label>
            <div class="ml-4">
                <x-radio-group name="platform" :allOpt="false" :options="\App\Models\Product::$platforms" wire:model.live="platform" />
            </div>
        </div>
    </div>

    <x-button class="ms-4" type="submit" wire:loading.attr="disabled">
        <span wire:loading.remove>Create</span>
        <span wire:loading>Saving…</span>
    </x-button>
</form>
