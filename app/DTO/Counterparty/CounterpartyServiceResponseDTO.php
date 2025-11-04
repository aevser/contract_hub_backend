<?php

namespace App\DTO\Counterparty;

use App\Models\Counterparty\Counterparty;

class CounterpartyServiceResponseDTO
{
    public function __construct(
        public bool $success,
        public ?Counterparty $data,
        public ?string $message,
        public int $code,
    ) {}

    public static function success(Counterparty $counterparty): self
    {
        return new self(
            success: true,
            data: $counterparty,
            message: null,
            code: 200,
        );
    }

    public static function error(string $message, int $code = 404): self
    {
        return new self(
            success: false,
            data: null,
            message: $message,
            code: $code,
        );
    }
}
