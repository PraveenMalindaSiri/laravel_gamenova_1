<x-layout>
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
                    Learn more
                </a>
            </div>
        </div>
    </div>

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
    
</x-layout>
