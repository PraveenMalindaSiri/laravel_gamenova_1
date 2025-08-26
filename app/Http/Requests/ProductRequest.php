<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('create', Product::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_photo' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120', // 5 MB
            ],

            'title' => [
                'required',
                'string',
                'max:150',
                Rule::unique('products', 'title')->where(fn($q) => $q->where('seller_id', Auth::user()->id)),
            ],

            'description' => ['required', 'string', 'max:2000'],

            'duration' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^\d{1,3}h(?:\s?\d{1,2}m)?$/i',
            ],

            'company' => ['nullable', 'string', 'max:120'],

            'price' => [
                'required',
                'numeric',
                'min:0',
                'max:999999.99',
            ],

            'released_date' => [
                'required',
                'date',
                'before_or_equal:today',
            ],

            'size' => [
                'required',
                'numeric',
                'min:0',
                'max:100000',
            ],

            'age_rating' => [
                'required',
                'integer',
                'between:0,100',
            ],

            'type' => [
                'required',
                Rule::in(Product::$type),
            ],

            'genre' => [
                'required',
                Rule::in(Product::$genres),
            ],

            'platform' => [
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
