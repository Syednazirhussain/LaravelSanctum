<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnnouncementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'subject'    => 'required|string|max:45',
            'message'    => 'required|string|max:255',
            'notify_via' => 'required|array|in:mail,database,vonage|min:1',
            'notify_to'  => 'required|string|in:all,waiter,chef',
        ];
    }
}
