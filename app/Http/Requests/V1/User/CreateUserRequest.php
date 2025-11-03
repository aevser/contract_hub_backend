<?php

namespace App\Http\Requests\V1\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class CreateUserRequest extends FormRequest
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
            'lastname' => ['nullable', 'string', 'max:255'],
            'name' => ['nullable', 'string', 'max:255'],
            'patronymic' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed']
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'lastname.string' => 'Фамилия должна быть строкой',
            'lastname.max' => 'Фамилия не должна превышать 255 символов',

            'name.string' => 'Имя должно быть строкой',
            'name.max' => 'Имя не должно превышать 255 символов',

            'patronymic.string' => 'Отчество должно быть строкой',
            'patronymic.max' => 'Отчество не должно превышать 255 символов',

            'email.required' => 'Email обязателен для заполнения',
            'email.string' => 'Email должен быть строкой',
            'email.email' => 'Введите корректный email адрес',
            'email.max' => 'Email не должен превышать 255 символов',
            'email.unique' => 'Пользователь с таким email уже существует',

            'password.required' => 'Пароль обязателен для заполнения',
            'password.string' => 'Пароль должен быть строкой',
            'password.min' => 'Пароль должен содержать минимум 6 символов',
            'password.confirmed' => 'Пароли не совпадают'
        ];
    }
}
