<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'type' => 'required|string|in:dine-in,take-away,delivery',
            'user_id' => 'required|exists:users,id',
            'waiter_id' => 'required_if:type,dine-in|exists:users,id|nullable',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:menu_items,id',
            'items.*.qty' => 'required|integer|min:1',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'type.required' => 'The order type is required.',
            'type.in' => 'The order type must be one of dine-in, take-away, or delivery.',
            'user_id.required' => 'The user ID is required.',
            'user_id.exists' => 'The selected user ID is invalid.',
            'waiter_id.required_if' => 'The waiter ID is required for dine-in orders.',
            'waiter_id.exists' => 'The selected waiter ID is invalid.',
            'items.required' => 'The items are required.',
            'items.array' => 'The items must be an array.',
            'items.min' => 'The order must contain at least one item.',
            'items.*.item_id.required' => 'The item ID is required for each item.',
            'items.*.item_id.exists' => 'The selected item ID is invalid.',
            'items.*.qty.required' => 'The quantity is required for each item.',
            'items.*.qty.integer' => 'The quantity must be an integer.',
            'items.*.qty.min' => 'The quantity must be at least 1.',
        ];
    }
}
