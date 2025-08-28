<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 mx-44 my-5">

    <header>
        @if (Route::has('login'))
            <nav class="bg-blue-800 rounded-lg shadow-lg shadow-slate-500 mb-5">
                <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
                    <div class="relative flex h-16 items-center justify-between">

                        {{-- web --}}
                        <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                            <div class="flex shrink-0 items-center">
                                <a href="{{ route('home') }}" class="text-xl text-skyblue hover:text-white">GameNova</a>
                            </div>
                            <div class="hidden sm:ml-6 sm:block">
                                <div class="flex space-x-4">
                                    <a href="{{ route('home') }}" class="link-nav">Home</a>
                                    <a href="{{ route('product.index') }}" class="link-nav">Games</a>
                                    @auth
                                        @if (Auth::user()->isCustomer())
                                            <a href="{{ route('wishlist.index') }}" class="link-nav">Wishlist</a>
                                            <a href="{{ route('cart.index') }}" class="link-nav">Cart</a>
                                        @endif
                                    @endauth
                                    <a href="{{ route('about') }}" class="link-nav">About</a>
                                </div>
                            </div>
                        </div>


                        {{-- settings --}}
                        <div
                            class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                            <div class="flex items-center">
                                @auth
                                    @php
                                        $dashboardRoute =
                                            auth()->user()->isSeller() || auth()->user()->isAdmin()
                                                ? route('myproducts.index')
                                                : route('orders.index');
                                    @endphp

                                    <div class="flex items-center space-x-5">
                                        <a href="{{ $dashboardRoute }}" class="btn-nav font-semibold">
                                            Dashboard
                                        </a>

                                        <form method="POST" action="{{ route('logout') }}" x-data>
                                            @csrf

                                            <button type="submit" class="btn-nav group">
                                                <x-logout class="hover:text-red-600 w-5 h-5"></x-logout>
                                                <span class="sr-only">Log out</span>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="flex items-center">
                                        <a href="{{ route('login') }}" class="btn-nav">
                                            Log in
                                        </a>

                                        @if (Route::has('register'))
                                            <a href="{{ route('register') }}" class="btn-nav">
                                                Register
                                            </a>
                                        @endif
                                    </div>
                                @endauth
                            </div>
                        </div>

                    </div>
                </div>
            </nav>
        @endif
    </header>


    @if (session('success'))
        <div role="alert" class="py-5 my-8 rounded-md border-l-4 border-green-600 bg-green-400 text-green-900">
            <p class="font-bold pl-10">Success!!!</p>
            <p class="pl-10">{{ session('success') }}</p>
        </div>
    @endif

    @if (session('error'))
        <div role="alert" class="py-5 my-8 rounded-md border-l-4 border-red-600 bg-red-400 text-red-900">
            <p class="font-bold pl-10">Error!!!</p>
            <p class="pl-10">{{ session('error') }}</p>
        </div>
    @endif

    {{ $slot }}
</body>

<footer class="bg-gray-900 text-white mt-5 rounded-lg">
    <div class="mx-auto max-w-7xl px-6 py-10">
        <section class="text-center max-w-3xl mx-auto space-y-3">
            <h3 class="text-2xl font-semibold">Explore Our Products</h3>
            <p class="text-lg text-gray-300">
                GameNova is your go-to marketplace for digital and physical games.
                Gamers and creators can buy and sell quality titles—with no region locks and great prices.
            </p>

            <a href="{{ route('product.index') }}"
                class="inline-flex items-center gap-2 text-cyan-400 hover:text-white font-medium transition">
                See all games ›
            </a>

        </section>

        <div class="mt-10 gap-8">
            <section class="w-full md:w-auto">
                <ul class="flex items-center justify-evenly">
                    <li>
                        <a href="https://www.facebook.com/" target="_blank"
                            class="group inline-flex h-10 w-10 items-center justify-center rounded-full ring-1 ring-white/10 hover:ring-cyan-400 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400">
                            <img src="{{ asset('assets/images/facebook.svg') }}" alt="Facebook"
                                class="w-5 h-5 opacity-80 transition" loading="lazy" decoding="async">
                            <span class="sr-only">Facebook</span>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.youtube.com/" target="_blank"
                            class="group inline-flex h-10 w-10 items-center justify-center rounded-full ring-1 ring-white/10 hover:ring-cyan-400 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400">
                            <img src="{{ asset('assets/images/youtube.svg') }}" alt="YouTube"
                                class="w-5 h-5 opacity-80 transition" loading="lazy" decoding="async">
                            <span class="sr-only">YouTube</span>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/" target="_blank"
                            class="group inline-flex h-10 w-10 items-center justify-center rounded-full ring-1 ring-white/10 hover:ring-cyan-400 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400">
                            <img src="{{ asset('assets/images/instagram.svg') }}" alt="Instagram"
                                class="w-5 h-5 opacity-80 transition" loading="lazy" decoding="async">
                            <span class="sr-only">Instagram</span>
                        </a>
                    </li>
                </ul>
            </section>
        </div>

        <div class="mt-8 border-t border-white/10 pt-4 text-center text-sm text-gray-400">
            &copy; {{ now()->year }} GameNova. All rights reserved.
        </div>
    </div>
</footer>


</html>
