<?php

namespace App\Services\Counterparty\Log;

use App\Enums\CounterpartyLogStatus;
use App\Repositories\Counterparty\Log\CounterpartyLogRepository;
use App\Repositories\Counterparty\Log\CounterpartyLogStatusRepository;

class CounterpartyLogService
{
    public function __construct(
        private CounterpartyLogRepository $counterpartyLogRepository,
        private CounterpartyLogStatusRepository $counterpartyLogStatusRepository
    ){}

    public function logSuccess(int $counterpartyId, string $message): void
    {
        $this->create(
            counterpartyId: $counterpartyId,
            statusId: $this->counterpartyLogStatusRepository->findByType(CounterpartyLogStatus::COMPLETED->value),
            message: $message
        );
    }

    public function logError(?int $userId, ?string $inn, string $message): void
    {
        if ($userId) { $message .= '| ИНН: ' . $inn.'.'; }

        if ($inn) { $message .= '| Пользователь: ' . $userId .'.'; }

        $this->create(
            counterpartyId: null,
            statusId: $this->counterpartyLogStatusRepository->findByType(CounterpartyLogStatus::ERROR->value),
            message: $message
        );
    }

    private function create(?int $counterpartyId, int $statusId, string $message): void
    {
        $this->counterpartyLogRepository->create(
            counterpartyId: $counterpartyId,
            statusId: $statusId,
            message: $message
        );
    }
}
