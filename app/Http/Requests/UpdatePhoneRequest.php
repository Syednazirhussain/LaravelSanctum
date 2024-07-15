<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePhoneRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'slug' => 'sometimes|string|unique:phones,slug,' . $this->route('phone'),
            'code' => 'sometimes|string|max:5',
            'number' => 'sometimes|string|max:15',
            'active' => 'boolean',
        ];
    }
}
