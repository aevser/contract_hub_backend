<?php

return [
    'counterparty' => [
        'inn' => [
            'required' => 'The INN field is required.',
            'string' => 'The INN must be a string.',
            'regex' => 'The INN must contain 10 digits (for organizations) or 12 digits (for individual entrepreneurs).',
            'unique' => 'A counterparty with this INN already exists in the system.'
        ]
    ],
    'user' => [
        'lastname' => [
            'string' => 'The lastname must be a string.',
            'max' => 'The lastname must not exceed 255 characters.'
        ],
        'name' => [
            'string' => 'The name must be a string.',
            'max' => 'The name must not exceed 255 characters.'
        ],
        'patronymic' => [
            'string' => 'The patronymic must be a string.',
            'max' => 'The patronymic must not exceed 255 characters.'
        ],
        'email' => [
            'required' => 'The email field is required.',
            'string' => 'The email must be a string.',
            'email' => 'Please enter a valid email address.',
            'max' => 'The email must not exceed 255 characters.',
            'unique' => 'A user with this email already exists.'
        ],
        'password' => [
            'required' => 'The password field is required.',
            'string' => 'The password must be a string.',
            'min' => 'The password must be at least 6 characters.',
            'confirmed' => 'The passwords do not match.'
        ]
    ]
];
