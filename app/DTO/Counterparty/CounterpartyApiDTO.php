<?php

namespace App\DTO\Counterparty;

class CounterpartyApiDTO
{
    public function __construct(public ?string $name, public ?string $ogrn, public ?string $address){}

    public static function fromApiResponse(array $data): self
    {
        return new self(
            name: $data['name']['short_with_opf'] ?? null,
            ogrn: $data['ogrn'] ?? null,
            address: $data['address']['unrestricted_value'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'ogrn' => $this->ogrn,
            'address' => $this->address,
        ];
    }
}
