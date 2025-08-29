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
