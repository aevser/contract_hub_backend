<?php

namespace App\DTO\User;

class CreateUserDTO
{
    public function __construct(
        public ?string $lastname,
        public ?string $name,
        public ?string $patronymic,
        public string $email,
        public string $password
    ){}

    public static function fromRequest(array $validated): self
    {
        return new self(
            lastname: $validated['lastname'] ?? null,
            name: $validated['name'] ?? null,
            patronymic: $validated['patronymic'] ?? null,
            email: $validated['email'],
            password: $validated['password']
        );
    }

    public function toArray(): array
    {
        return [
            'lastname' => $this->lastname,
            'name' => $this->name,
            'patronymic' => $this->patronymic,
            'email' => $this->email,
            'password' => $this->password
        ];
    }
}
