<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 mx-60 my-5">

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
                                    <a href="{{ route('about') }}" class="link-nav">About</a>
                                    <a href="#" class="link-nav">Wishlist</a>
                                    <a href="#" class="link-nav">Cart</a>
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
                                        <a href="{{ $dashboardRoute }}" class="btn-nav">
                                            Dashboard
                                        </a>

                                        <form method="POST" action="{{ route('logout') }}" x-data>
                                            @csrf

                                            <button class="btn-nav hover:text-red-500">
                                                Logout
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="flex items-center space-x-5">
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

</html>
