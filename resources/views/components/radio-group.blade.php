<div>
    @if ($allOpt)
        <div class="flex">
            <label class="mb-1 flex items-center cursor-pointer">
                <input type="radio" name="{{ $name }}" id="" value=""
                    @checked(!request($name)){{ $attributes->whereStartsWith('wire:model') }}>
                <span class="ml-2">All</span>
            </label>
        </div>
    @endif

    @foreach ($optionsWithLabels as $lable => $opt)
        <div class="flex">
            <label class="flex items-center cursor-pointer mb-2">
                <input type="radio" name="{{ $name }}" value="{{ $opt }}" @checked($opt === ($value ?? request($name)))
                    {{ $attributes->whereStartsWith('wire:model') }}>
                <span class="ml-2">{{ $opt }}</span>
            </label>
        </div>
    @endforeach

    @error($name)
        <div class="mt-1 text-xs text-red-600">
            {{ $message }}
        </div>
    @enderror
</div>
