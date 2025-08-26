<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased">
    <x-banner />

    <div class="min-h-screen bg-gray-100">
        @livewire('navigation-menu')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <div class="mx-20">
            @if (session('success'))
                <div role="alert"
                    class="py-5 mt-8 rounded-md border-l-4 border-green-600 bg-green-400 text-green-900">
                    <p class="font-bold pl-10">Success!!!</p>
                    <p class="pl-10">{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div role="alert" class="py-5 mt-8 rounded-md border-l-4 border-red-600 bg-red-400 text-red-900">
                    <p class="font-bold pl-10">Error!!!</p>
                    <p class="pl-10">{{ session('error') }}</p>
                </div>
            @endif
        </div>

        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('modals')

    @livewireScripts
</body>

</html>
