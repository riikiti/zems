<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class ProjectStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|min:2',
            'description' => 'nullable|string',
            'logo' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            '*.required' => 'Поле обязательно',
            '*.unique' => 'Данная почта уже зарегистрирована на сайте',
        ];
    }
}
