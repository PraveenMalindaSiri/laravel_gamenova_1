@extends('layouts.layout')

@section('title', 'Game Details')

@section('content')

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
                <div class="text-3xl font-semibold leading-tight">
                    {{ $product->title }}
                    @if ($product->deleted_at)
                        <span class="text-xl text-red-800">- Deleted</span>
                    @endif
                    @if ($product->featured)
                        <span class="text-xl text-yellow-800">- Featured 🔥</span>
                    @endif
                </div>

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

                @if (!$product->deleted_at && Auth::user()->isCustomer() && Auth::user()->dob)
                    <div class="flex flex-wrap items-end gap-3">
                        <form action="{{ route('cart.store') }}" method="POST" class="flex items-end gap-3">
                            @csrf

                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            @if (strtolower($product->type) !== 'digital')
                                <div class="w-28">
                                    <x-input-field name="quantity" type="number" label="Quantity" min="1"
                                        value="1" />
                                </div>
                            @else
                                <input type="hidden" name="quantity" value="1">
                            @endif

                            <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-white hover:bg-slate-600">
                                Add to Cart
                            </button>

                            {{-- action for Wishlist --}}
                            <button type="submit" formaction="{{ route('wishlist.store') }}" formmethod="POST"
                                class="rounded-lg border border-slate-300 px-4 py-2 hover:text-blue-700">
                                Add to Wishlist
                            </button>
                        </form>
                    </div>
                @endif

                @if (Auth::user()->isCustomer() && !Auth::user()->dob)
                    <div>
                        <p class="mb-2 text-red-700">
                            Your date of birth is missing from your profile. Please update it to continue using all
                            features.
                        </p>
                        <a href="{{ route('profile.show') }}"
                            class="bg-slate-900 p-1 text-white rounded-md hover:bg-slate-600">Update ›
                        </a>
                    </div>
                @endif

                @if (Auth::user()->isSeller() && $product->seller_id === Auth::user()->id)
                    <div>
                        @if (!$product->deleted_at)
                            <a href="{{ route('myproducts.edit', $product) }}"
                                class="bg-slate-900 py-2 px-4 text-white rounded-md hover:bg-slate-600">Manage</a>
                        @else
                            <a href="{{ route('myproducts.index') }}"
                                class="bg-slate-900 py-2 px-4 text-white rounded-md hover:bg-slate-600">Manage</a>
                        @endif
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
