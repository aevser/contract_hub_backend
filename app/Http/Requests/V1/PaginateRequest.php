<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class PaginateRequest extends FormRequest
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
            'perPage' => 'nullable|integer|min:1|max:100',
            'page' => 'nullable|integer|min:1'
        ];
    }

    public function messages(): array
    {
        return [
            'perPage.integer' => 'Количество элементов на странице должно быть числом.',
            'perPage.min' => 'Минимальное количество элементов на странице: 1.',
            'perPage.max' => 'Максимальное количество элементов на странице: 100.',

            'page.integer' => 'Номер страницы должен быть числом.',
            'page.min' => 'Номер страницы должен быть больше 0.'
        ];
    }
}
