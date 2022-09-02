<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegistrationRequest extends FormRequest
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
            'name' => 'required|string|min:3',
            'surname' => 'string|min:3|nullable',
            'role' => 'required|in:1,2,3',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|confirmed',
        ];
    }
}
