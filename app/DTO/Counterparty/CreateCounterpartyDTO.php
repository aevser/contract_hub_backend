<?php

namespace App\DTO\Counterparty;

class CreateCounterpartyDTO
{
    public function __construct(
        public int $userId,
        public string $inn,
        public ?string $name,
        public ?string $ogrn,
        public ?string $address
    ) {}

    public static function fromCreateDTO(CounterpartyDTO $counterpartyDTO, CounterpartyApiDTO $counterpartyApiDTO): self
    {
        return new self(
            userId: $counterpartyDTO->userId,
            inn: $counterpartyDTO->inn,
            name: $counterpartyApiDTO->name,
            ogrn: $counterpartyApiDTO->ogrn,
            address: $counterpartyApiDTO->address
        );
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'inn' => $this->inn,
            'name' => $this->name,
            'ogrn' => $this->ogrn,
            'address' => $this->address
        ];
    }
}
