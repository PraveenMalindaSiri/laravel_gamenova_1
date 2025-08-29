<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'GameNova')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="bg-slate-100 mx-44 my-5">

    <x-nav />

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

    @yield('content')

    @stack('scripts')
</body>

<x-footer />

</html>
