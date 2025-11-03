<?php

namespace App\Http\Requests\V1\Counterparty;

use Illuminate\Foundation\Http\FormRequest;

class CreateCounterpartyRequest extends FormRequest
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
            'inn' => ['required', 'string', 'regex:/^\d{10}$|^\d{12}$/', 'unique:counterparties,inn']
        ];
    }

    public function messages(): array
    {
        return [
            'inn.required' => 'ИНН обязателен для заполнения',
            'inn.string' => 'ИНН должен быть строкой',
            'inn.regex' => 'ИНН должен содержать 10 цифр (для организаций) или 12 цифр (для ИП)',
            'inn.unique' => 'Контрагент с таким ИНН уже добавлен в систему'
        ];
    }
}
