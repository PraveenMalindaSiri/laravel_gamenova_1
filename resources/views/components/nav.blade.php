<header>
    @if (Route::has('login'))
        <nav class="bg-gradient-to-br from-blue-900 via-blue-600 to-sky-700 rounded-lg shadow-lg shadow-slate-500 mb-5">
            <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
                <div class="relative flex h-16 items-center justify-between">

                    {{-- web --}}
                    <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                        <div class="flex shrink-0 items-center">
                            <a href="{{ route('home') }}"
                                class="text-xl text-skyblue hover:text-white transition duration-300">GameNova</a>
                        </div>
                        <div class="hidden sm:ml-6 sm:block">
                            <div class="flex space-x-4">
                                <a href="{{ route('home') }}"
                                    class="link-nav {{ request()->routeIs('home') ? 'bg-blue-900 text-white' : '' }}">Home</a>
                                <a href="{{ route('product.index') }}"
                                    class="link-nav {{ request()->routeIs('product.*') ? 'bg-blue-900 text-white' : '' }}">Games</a>
                                @auth
                                    @if (Auth::user()->isCustomer())
                                        <a href="{{ route('wishlist.index') }}"
                                            class="link-nav {{ request()->routeIs('wishlist.*') ? 'bg-blue-900 text-white' : '' }}">Wishlist</a>
                                        <a href="{{ route('cart.index') }}"
                                            class="link-nav {{ request()->routeIs('cart.*') ? 'bg-blue-900 text-white' : '' }}">Cart</a>
                                    @endif
                                @endauth
                                <a href="{{ route('about') }}"
                                    class="link-nav {{ request()->routeIs('about') ? 'bg-blue-900 text-white' : '' }}">About</a>
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
                                            <x-logout
                                                class="w-5 h-5 text-white/70 hover:text-white transition duration-200" />
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
