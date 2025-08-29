<?php

namespace App\Livewire;

use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PaymentForm extends Component
{
    public $cardNumber;
    public $expiry;
    public $cvv;
    public $amount;

    protected $rules = [
        'cardNumber' => 'required|digits:16',
        'expiry'     => 'required|date_format:m/y|after:today',
        'cvv'        => 'required|digits:3',
        'amount'     => 'required|numeric|min:1',
    ];

    public function submit(OrderService $orders)
    {
        $this->validate();

        try {
            $order = $orders->createFromCart(Auth::user()->id); // running the DB transaction
        } catch (\Throwable $th) {
            return redirect()
                ->route('cart.index')
                ->with('error', $th->getMessage());
        }

        return redirect()->route('orders.index')->with('success', 'Order placed successfully. View more details here');
    }

    public function updated($property)
    {
        // Live validation as you type
        $this->validateOnly($property);
    }

    public function render()
    {
        return view('livewire.payment-form');
    }
}
