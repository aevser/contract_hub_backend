<?php

namespace App\DTO\Counterparty;

class CounterpartyDTO
{
    public function __construct(public int $userId, public string $inn){}

    public static function fromRequest(int $userId, array $validated): self
    {
        return new self(userId: $userId, inn: $validated['inn']);
    }
}
