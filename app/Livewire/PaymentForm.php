<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PaymentForm extends Component
{
    public $cardNumber;
    public $expiry;
    public $cvv;
    public $amount;
    public $address;

    protected $rules = [
        'cardNumber' => 'required|digits:16',
        'expiry'     => ['required', 'regex:/^(0[1-9]|1[0-2])\/\d{2}$/'],
        'cvv'        => 'required|digits:3',
        'address' => 'required|string|min:5'
    ];

    public function mount()
    {
        $this->amount = $this->calculateCartTotal();
    }

    private function calculateCartTotal(): float
    {
        $carts = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        return (float) $carts->sum(fn($c) => (float)$c->product->price * (int)$c->quantity);
    }

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
