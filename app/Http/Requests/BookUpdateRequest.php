<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'author' => 'nullable|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            
           'translations' => ['required', 'array'],
        'translations.*' => ['required', 'array'],
        'translations.*.*' => ['required', 'array'],
        'translations.*.*.title' => ['sometimes', 'required', 'string', 'max:255'],
        'translations.*.*.description' => ['sometimes', 'required', 'string'],
        ];
    }
}
