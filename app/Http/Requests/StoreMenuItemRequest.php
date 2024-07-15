<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMenuItemRequest extends FormRequest
{
    public function authorize()
    {
        return true; // You might want to add authorization logic here
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'item_category_id' => 'required|exists:menu_item_categories,id',
            'img' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->header('Content-Type') !== 'application/json') {
            abort(415, 'Unsupported Media Type. Content-Type must be application/json.');
        }
    }
}
