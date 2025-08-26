<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        $product = $this->route('product') ?? $this->route('myproduct');
        return $product ? Gate::allows('update', $product) : false;
    }

    public function rules(): array
    {
        /** @var \App\Models\Product $product */
        $product = $this->route('product');

        return [
            'product_photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'title' => [
                'sometimes',
                'required',
                'string',
                'max:150',
                Rule::unique('products', 'title')
                    ->where(fn($q) => $q->where('seller_id', Auth::user()->id))
                    ->ignore($product?->id),
            ],

            'description' => ['sometimes', 'required', 'string', 'max:2000'],

            'duration' => [
                'sometimes',
                'nullable',
                'string',
                'max:20',
                'regex:/^\d{1,3}h(?:\s?\d{1,2}m)?$/i',
            ],

            'company' => ['sometimes', 'nullable', 'string', 'max:120'],

            'price' => [
                'sometimes',
                'required',
                'numeric',
                'min:0',
                'max:999999.99',
            ],

            'released_date' => [
                'sometimes',
                'required',
                'date',
                'before_or_equal:today',
            ],

            'size' => [
                'sometimes',
                'required',
                'numeric',
                'min:0',
                'max:100000',
            ],

            'age_rating' => [
                'sometimes',
                'required',
                'integer',
                'between:0,100',
            ],

            'type' => [
                'sometimes',
                'required',
                Rule::in(Product::$type),
            ],

            'genre' => [
                'sometimes',
                'required',
                Rule::in(Product::$genres),
            ],

            'platform' => [
                'sometimes',
                'required',
                Rule::in(Product::$platforms),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'duration.regex' => 'Duration must look like "12h 30m" or "5h".',
        ];
    }
}
