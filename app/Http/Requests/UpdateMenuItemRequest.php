<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMenuItemRequest extends FormRequest
{
    public function authorize()
    {
        return true; // You might want to add authorization logic here
    }

    public function rules()
    {
        return [
            'name' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric|min:0',
            'item_category_id' => 'sometimes|exists:menu_item_categories,id',
            'img' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:5120',
        ];
    }
}
