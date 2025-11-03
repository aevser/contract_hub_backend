<?php

namespace App\Repositories\Counterparty\Log;

use App\Models\Counterparty\Log\CounterpartyLog;

class CounterpartyLogRepository
{
    public function __construct(private CounterpartyLog $counterpartyLog){}

    public function create(?int $counterpartyId, int $statusId, ?string $message): CounterpartyLog
    {
        return $this->counterpartyLog->query()->create(['counterparty_id' => $counterpartyId, 'status_id' => $statusId, 'message' => $message]);
    }
}
