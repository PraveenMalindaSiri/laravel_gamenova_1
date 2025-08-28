<?php

namespace App\Livewire;

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

    public function submit()
    {
        $this->validate();

        session()->flash('success', 'Payment processed successfully.');

        // return redirect()->route('purchase.create');
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
