<div class="max-w-md mx-auto mt-10 p-6 bg-slate-200 shadow-lg rounded-2xl">
    <h2 class="text-xl font-bold mb-4">Payment Page</h2>

    <form wire:submit.prevent="submit" class="space-y-4">
        <div>
            <x-input-field name="cardNumber" label="Card Number" required wire:model.live="cardNumber" />
        </div>

        <div>
            <x-input-field name="expiry" label="Expiry (MM/YY)" required wire:model.live="expiry" />
        </div>

        <div>
            <x-input-field name="cvv" label="CVV" required type="password"
                wire:model.live="cvv" />
        </div>

        <div>
            <x-input-field name="amount" label="Amount" required wire:model.live="amount" readonly />
        </div>

        <div>
            <x-input-field name="address" label="Address" required wire:model.live="address" />
        </div>

        <x-button>Pay Now</x-button>
    </form>
</div>
