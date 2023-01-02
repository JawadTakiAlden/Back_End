<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => "string|min:3|max:20",
            'last_name' => "string|min:3|max:20",
            'phone' => 'string',
            'address' => 'string',
            'image' => 'mimes:png,jpg,jpeg|max:6000'
        ];
    }
}
