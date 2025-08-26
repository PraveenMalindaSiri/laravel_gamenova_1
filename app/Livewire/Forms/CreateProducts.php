<?php

namespace App\Livewire\Forms;

use App\Http\Controllers\Dashboard\ProductController;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateProducts extends Component
{
    use WithFileUploads;

    public $product_photo;
    public ?Product $product = null;
    public string $title = '';
    public string $type = '';
    public string $genre = '';
    public string $duration = '';
    public string $company = '';
    public string $platform = '';
    public ?float $price = null;
    public ?string $released_date = null;
    public ?float $size = null;
    public ?int $age_rating = null;
    public ?string $description = null;

    public function rules(): array
    {
        $imageRule = $this->isEdit()
            ? ['nullable', 'image', 'max:2000']
            : ['required', 'image', 'max:2000'];

        return [
            'product_photo' => $imageRule,
            'title'         => ['required', 'string', 'min:3', 'max:120'],
            'type'          => ['required', Rule::in(Product::$type)],
            'genre'         => ['required', Rule::in(Product::$genres)],
            'duration'      => ['required', 'string', 'max:50'],
            'company'       => ['required', 'string', 'max:120'],
            'platform'      => ['required', Rule::in(Product::$platforms)],
            'price'         => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'released_date' => ['required', 'date', 'before_or_equal:today'],
            'size'          => ['required', 'numeric', 'min:0', 'max:999.99'],
            'age_rating'    => ['required', 'integer', 'min:0', 'max:99'],
            'description'   => ['required', 'string', 'max:5000'],
        ];
    }

    public function mount(?Product $product = null)
    {
        $this->product = $product;

        if ($this->isEdit()) {
            $this->authorize('update', $product);

            $this->title         = $product->title ?? '';
            $this->type          = $product->type ?? '';
            $this->genre         = $product->genre ?? '';
            $this->duration      = $product->duration ?? '';
            $this->company       = $product->company ?? '';
            $this->platform      = $product->platform ?? '';
            $this->price         = is_null($product->price) ? null : (float)$product->price;
            $this->released_date = $product->released_date?->format('Y-m-d');
            $this->size          = is_null($product->size) ? null : (float)$product->size;
            $this->age_rating    = is_null($product->age_rating) ? null : (int)$product->age_rating;
            $this->description   = $product->description;
        } else {
            $this->authorize('create', Product::class);
        }
    }

    public function isEditing(): bool
    {
        return (bool) $this->product?->exists;
    }

    public function updated($field)
    {
        $this->validateOnly($field);
    }

    public function render()
    {
        $data = [
            'mode' => $this->isEdit() ? 'edit' : 'create',
        ];

        if ($this->isEdit()) {
            $data['product'] = $this->product;
        }

        return view('dashboard.seller.create', $data);
    }
}
