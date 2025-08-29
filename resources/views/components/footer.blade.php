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
