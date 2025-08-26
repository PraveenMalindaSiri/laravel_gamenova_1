<div class="w-full">
    @php
        $base = 'block w-full rounded-xl border px-3 py-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500';
        $error = $errors->has($name) ? ' border-red-500 focus:border-red-500 focus:ring-red-500' : '';
    @endphp
    
    @if ($label)
        <label for="{{ $name }}" class="mb-1 block text-sm font-medium text-gray-700">
            {{ $label }} @if ($required)
                <span class="text-red-600">*</span>
            @endif
        </label>
    @endif

    <input name="{{ $name }}" type="{{ $type }}" value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}" @if ($required) required @endif
        {{ $attributes->merge(['class' => $base . $error]) }} />

    @error($name)
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>
