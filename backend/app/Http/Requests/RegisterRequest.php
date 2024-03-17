<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users,email',
            'password'=>'required|string',
            'confirm_password'=>'required|string|same:password',
            'name'=>'required|string',
            'role'=>'required|string',
        ];
    }
    public function messages(): array
    {
        return [
            '*.required' => 'error',
            'email.unique' => 'Данная почта уже зарегистрирована на сайте',
        ];
    }
}
