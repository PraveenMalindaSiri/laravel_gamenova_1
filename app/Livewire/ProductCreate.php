<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ProductCreate extends Component
{
    use WithFileUploads, AuthorizesRequests;

    // form state mirrors your inputs
    public $product_photo;
    public $title = '';
    public $description = '';
    public $duration = '';
    public $size;
    public $age_rating;
    public $company = '';
    public $price;
    public $released_date;
    public $type;
    public $genre;
    public $platform;

    // for your radios
    public array $types = [];
    public array $genres = [];
    public array $platforms = [];

    public function mount()
    {
        Gate::authorize('create', Product::class);
        $this->types     = Product::$type;
        $this->genres    = Product::$genres;
        $this->platforms = Product::$platforms;
    }

    public function rules()
    {
        return [
            'product_photo' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'title' => [
                'required',
                'string',
                'max:150',
                'min:3',
                Rule::unique('products', 'title')->where(fn($q) => $q->where('seller_id', Auth::id())),
            ],
            'description'   => 'required|string|max:2000|min:3',
            'duration'      => ['required', 'string', 'max:20', 'regex:/^\d{1,3}h(?:\s?\d{1,2}m)?$/i'],
            'company'       => ['required', 'string', 'max:120','min:2'],
            'price'         => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'released_date' => ['required', 'date', 'before_or_equal:today'],
            'size'          => ['required', 'numeric', 'min:0', 'max:100000'],
            'age_rating'    => ['required', 'integer', 'between:0,100'],
            'type'          => ['required', Rule::in(Product::$type)],
            'genre'         => ['required', Rule::in(Product::$genres)],
            'platform'      => ['required', Rule::in(Product::$platforms)],
        ];
    }

    public function messages(): array
    {
        return ['duration.regex' => 'Duration must look like "12h 30m" or "5h".'];
    }

    public function updated($field)
    {
        $this->validateOnly($field);
    }

    public function save()
    {
        Gate::authorize('create', Product::class);
        $this->validate();

        $path = $this->storePhoto($this->product_photo);

        Product::create([
            'seller_id'          => Auth::id(),
            'product_photo_path' => $path,
            'title'              => $this->title,
            'description'        => $this->description,
            'duration'           => $this->duration ?: null,
            'company'            => $this->company ?: null,
            'price'              => $this->price,
            'released_date'      => $this->released_date,
            'size'               => $this->size,
            'age_rating'         => $this->age_rating,
            'type'               => $this->type,
            'genre'              => $this->genre,
            'platform'           => $this->platform,
        ]);

        session()->flash('success', 'Product created');
        return redirect()->route('myproducts.index');
    }

    protected function storePhoto(UploadedFile $file, string $dir = 'products', string $disk = 's3'): string
    {
        $ext       = $file->getClientOriginalExtension();
        $basename  = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeName  = Str::slug($basename);
        $timestamp = now()->format('Ymd_His');
        $rand      = Str::random(6);
        $filename  = "{$safeName}_{$timestamp}_{$rand}.{$ext}";
        return $file->storeAs($dir, $filename, $disk);
    }

    public function render()
    {
        return view('livewire.product-create');
    }
}
