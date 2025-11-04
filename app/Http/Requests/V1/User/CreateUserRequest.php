<?php

namespace App\Http\Requests\V1\User;

use Illuminate\Foundation\Http\FormRequest;

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
            'lastname.string' => __('validations.user.lastname.string'),
            'lastname.max' => __('validations.user.lastname.max'),

            'name.string' => __('validations.user.name.string'),
            'name.max' => __('validations.user.name.max'),

            'patronymic.string' => __('validations.user.patronymic.string'),
            'patronymic.max' => __('validations.user.patronymic.max'),

            'email.required' => __('validations.user.email.required'),
            'email.string' => __('validations.user.email.string'),
            'email.email' => __('validations.user.email.email'),
            'email.max' => __('validations.user.email.max'),
            'email.unique' => __('validations.user.email.unique'),

            'password.required' => __('validations.user.password.required'),
            'password.string' => __('validations.user.password.string'),
            'password.min' => __('validations.user.password.min'),
            'password.confirmed' => __('validations.user.password.confirmed.')
        ];
    }
}
