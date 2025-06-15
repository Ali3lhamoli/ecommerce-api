<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'items.required' => 'The order must include at least one item.',
            'items.*.product_id.required' => 'Each item must have a product.',
            'items.*.product_id.exists' => 'One of the selected products does not exist.',
            'items.*.quantity.required' => 'Each item must have a quantity.',
            'items.*.quantity.integer' => 'Quantity must be a number.',
            'items.*.quantity.min' => 'Quantity must be at least 1.',
        ];
    }
}
