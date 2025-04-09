<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{

    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name'          => ['required', 'string', 'min:3', 'max:255'],
            'description'   => ['nullable', 'string'],
            'price'         => ['required', 'numeric', 'min:0', 'max:9999999.99'],
            'image'         => ['nullable', 'image', 'max:2048', 'mimes:jpeg,png,jpg,gif'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'The product name is required.',
            'name.min'          => 'The product name must be at least 3 characters.',
            'price.required'    => 'The product price is required.',
            'price.numeric'     => 'The price must be a valid number.',
            'price.min'         => 'The price cannot be negative.',
            'image.image'       => 'The file must be an image.',
            'image.max'         => 'The image size cannot exceed 2MB.',
            'image.mimes'       => 'The image must be a file of type: jpeg, png, jpg, gif.',
        ];
    }
}
