<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePermissionRequest extends FormRequest
{
    public function authorize()
    {
        return true; // You might want to add authorization logic here
    }

    public function rules()
    {
        return [
            'permission_name' => 'required|string|max:255',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->header('Content-Type') !== 'application/json') {
            abort(415, 'Unsupported Media Type. Content-Type must be application/json.');
        }
    }
}
