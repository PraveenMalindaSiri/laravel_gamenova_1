@extends('layouts.layout')

@section('title', 'GameNova Cart')

@section('content')


    @forelse ($carts as $cart)
        <x-game-card :product="$cart->product" :games="false" :fromCart="true" cartAmount="{{ $cart->quantity }}"
            cartItemID="{{ $cart->id }}" />

    @empty
        <div class="text-sm font-semibold text-center my-64">
            No Cart Items!!!
        </div>
    @endforelse

    <div class="flex justify-between mx-20 rounded-md border border-black p-5 items-center">
        <div class="flex flex-col">
            <div class="text-lg text-slate-700 font-semibold">
                Total Price: Rs. {{ $totalPrice }} + tax%
            </div>
            <div class="text-sm text-slate-700 font-semibold">Games: {{ $games }}</div>
            <div class="text-sm text-slate-700 font-semibold">Items: {{ $items }}</div>
        </div>

        <div>
            <a href="{{ route('payment.page') }}"
                class="bg-slate-900 py-2 px-4 text-white rounded-md hover:bg-slate-600">Proceed To Checkout</a>
        </div>
    </div>

@endsection
