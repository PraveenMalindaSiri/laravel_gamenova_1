@extends('layouts.layout')

@section('title', 'GameNova About')

@section('content')
    {{--  --}}
    <div style="background-image: url('{{ asset('assets/images/about.png') }}');"
        class="bg-cover bg-center h-max text-white w-[100%] rounded-lg">
        <section class="w-[70%] text-center mx-auto text-lg pt-5">
            <p>Welcome to GameNova, a marketplace to buy and sell physical and Digital games. Our community is for
                gamers that want to explore the wide gaming world.</p><br>
            <p>At GameNova gamers can buy their favorite games at a great price.
                Sellers can sell their games to test their skills and strength in the industry.
                We believe having a platform to connect gamers and game sellers can help the gaming industry to grow
                quickly.</p><br>
            <p>We support physical and digital copies of any game for all major platforms like PC, Xbox, and
                PlayStation.</p><br>
            <p>Thank you for being a part of our family.</p><br>
            <p>Level Up with us - one game at a time.</p><br>
        </section>
    </div>

    <div class="w-full rounded-lg bg-[color:#1A1C1E] py-10 mt-5">
        <h2 class="text-white text-3xl font-semibold text-center mb-10">Our Partners</h2>

        <ul role="list"
            class="mx-auto max-w-6xl grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6
             gap-x-8 gap-y-10 items-center justify-items-center px-6">
            @foreach ([['name' => 'PlayStation', 'src' => asset('assets/partners/ps.svg'), 'url' => 'https://www.playstation.com'], ['name' => 'Bethesda', 'src' => asset('assets/partners/bethesda.svg'), 'url' => 'https://bethesda.net'], ['name' => 'Xbox', 'src' => asset('assets/partners/xbox.svg'), 'url' => 'https://www.xbox.com'], ['name' => 'Steam', 'src' => asset('assets/partners/steam.svg'), 'url' => 'https://store.steampowered.com'], ['name' => 'EA', 'src' => asset('assets/partners/ea.svg'), 'url' => 'https://www.ea.com'], ['name' => 'Ubisoft', 'src' => asset('assets/partners/ubisoft.svg'), 'url' => 'https://www.ubisoft.com'], ['name' => 'Activision', 'src' => asset('assets/partners/activision.svg'), 'url' => 'https://www.activision.com'], ['name' => 'CD PROJEKT RED', 'src' => asset('assets/partners/cdpr.svg'), 'url' => 'https://www.cdprojektred.com'], ['name' => 'Rockstar Games', 'src' => asset('assets/partners/rockstar.svg'), 'url' => 'https://www.rockstargames.com']] as $logo)
                <li class="h-20 w-32 flex items-center justify-center rounded-md bg-white ring-1 ring-white/10">
                    <a href="{{ $logo['url'] }}" target="_blank" rel="noopener" class="inline-flex">
                        <img src="{{ $logo['src'] }}" alt="{{ $logo['name'] }}" loading="lazy" decoding="async"
                            class="max-h-12 w-auto object-contain grayscale hover:opacity-100 hover:grayscale-0 transition" />
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
