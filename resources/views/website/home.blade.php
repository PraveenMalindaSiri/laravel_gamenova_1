@extends('layouts.layout')

@section('title', 'GameNova')

@section('content')

    <div>
        <div style="background-image: linear-gradient(to bottom, rgba(0,0,0,.55), rgba(0,0,0,.25)), url('{{ asset('assets/images/main img.png') }}');"
            class="hidden md:block bg-cover bg-center w-full text-white rounded-lg">
            <h1 class="md:text-4xl font-bold p-4 ml-10 pt-5">Welcome to GameNova.</h1>
            <p class="md:text-xl text-left w-1/3 p-4 ml-10">
                Level up your game collection now.
                Buy physical or digital edition of your next game.
                No region locks. No other barriers. Just pure gaming vibe.
                Gear up and game on!
            </p>
            <div class="flex gap-4 p-8">
                <a href="{{ route('product.index') }}"
                    class="inline-flex items-center rounded-lg bg-cyan-500 px-5 py-3 font-semibold text-black hover:bg-cyan-400 transition">
                    Shop games
                </a>
                <a href="{{ route('about') }}"
                    class="inline-flex items-center rounded-lg ring-1 ring-white/20 px-5 py-3 font-semibold text-white hover:bg-white/10 transition">
                    Learn more ›
                </a>
            </div>
        </div>
    </div>

    {{-- images section --}}
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 my-5">
        <div><img src="{{ asset('assets/images/intro_img.jpg') }}" alt="Intro Image" class="rounded-lg" width="270">
        </div>
        <div> <video autoplay muted loop class="rounded-lg">
                <source src="{{ asset('assets/images/intro_vid.mp4') }}" type="video/mp4">
            </video>
        </div>
        <div><img src="{{ asset('assets/images/intro_img2.jpg') }}" alt="Intro Image" class="rounded-lg" width="270">
        </div>
    </div>

    {{-- New releases section --}}
    <div
        class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mt-10 p-4 rounded-lg bg-gradient-to-br from-blue-900 via-cyan-600 to-gray-800
">
        <div class="flex items-end justify-between mb-2">
            <div>
                <h2 class="text-2xl font-bold mb-1 text-white">Latest Releases</h2>
                <p class="text-md text-slate-200">Fresh drops—grab them while they’re hot.</p>
            </div>
            <a href="{{ route('product.index') }}" class="text-md font-semibold text-slate-300 hover:text-white transition-all duration-300 hover:underline">
                View all ›
            </a>
        </div>

        <div class="max-h-[570px] overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-cyan-500 scrollbar-track-gray-700">
            @forelse ($products as $product)
                <x-game-card :product="$product" :games="true" />
            @empty
                <div class="col-span-full">
                    <div class="text-sm font-semibold text-center py-16 border border-dashed rounded-xl text-slate-100">
                        No games for now — check back soon!
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Featured section --}}
    <div
        class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mt-10 p-4 rounded-lg bg-gradient-to-br from-red-800 via-red-600 to-orange-500">
        <div class="flex items-end justify-between mb-2">
            <div>
                <h2 class="text-2xl font-bold mb-1 text-white">Featured Games</h2>
                <p class="text-md text-slate-200">Hand-picked titles our team recommends for every gamer.</p>
            </div>
            <a href="{{ route('product.index') }}" class="text-md font-semibold text-slate-300 hover:text-white transition-all duration-300 hover:underline">
                View all ›
            </a>
        </div>

        <div class="max-h-[570px] overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-cyan-500 scrollbar-track-gray-700">
            @forelse ($featured as $product)
                <x-game-card :product="$product" :games="true" />
            @empty
                <div class="col-span-full">
                    <div class="text-sm font-semibold text-center py-16 border border-dashed rounded-xl text-slate-100">
                        No games for now — check back soon!
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
