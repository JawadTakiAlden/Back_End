<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'first_name' => ['required' , 'min:3' , 'max:20' , 'string'],
            'last_name' =>['required' , 'min:3' , 'max:20' , 'string'],
            'email' => ['required' , 'email' , 'unique:users,email'],
            'password' => ['required' , 'min:8'],
            'role_id' => ['required'],
            'image' => ['mimes:png,jpg,jpeg','max:6000']
        ];
    }
}
