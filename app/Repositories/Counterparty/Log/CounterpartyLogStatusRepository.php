<?php

namespace App\Repositories\Counterparty\Log;

use App\Models\Counterparty\Log\CounterpartyLogStatuses;

class CounterpartyLogStatusRepository
{
    public function __construct(private CounterpartyLogStatuses $counterpartyLogStatuses){}

    public function findByType(string $type): ?int
    {
        return $this->counterpartyLogStatuses->query()->where('type', $type)->value('id');
    }
}
