<?php

namespace App\Services\Counterparty;

use App\DTO\Counterparty\CounterpartyApiDTO;
use App\DTO\Counterparty\CounterpartyDTO;
use App\DTO\Counterparty\CounterpartyServiceResponseDTO;
use App\DTO\Counterparty\CreateCounterpartyDTO;
use App\Repositories\Counterparty\CounterpartyRepository;
use App\Services\Counterparty\Log\CounterpartyLogService;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class CounterpartyService
{
    private string $token;
    private string $url;

    public function __construct(
        private CounterpartyRepository $counterpartyRepository,
        private CounterpartyLogService $counterpartyLogService
    )
    {
        $this->token = config('da_data.da_data_token');
        $this->url = config('da_data.da_data_url');
    }

    // Запрос + создание записи
    public function create(CounterpartyDTO $DTO): CounterpartyServiceResponseDTO
    {
        $data = $this->getCompanyByInn(userId: $DTO->userId, inn: $DTO->inn);

        if (!$data) { return CounterpartyServiceResponseDTO::error(message: __('responses.counterparty.not_found')); }

        $createDTO = CreateCounterpartyDTO::fromCreateDTO(counterpartyDTO: $DTO, counterpartyApiDTO: $data);

        $counterparty = $this->counterpartyRepository->create(DTO: $createDTO);

        $this->counterpartyLogService->logSuccess(counterpartyId: $counterparty->id, message: __('responses.counterparty.success'));

        return CounterpartyServiceResponseDTO::success(counterparty: $counterparty);
    }

    // Получение и обработка результата
    private function getCompanyByInn(int $userId, string $inn): ?CounterpartyApiDTO
    {
        try {
            $response = $this->sendData(inn: $inn);

            if (!$response->successful()) {
                $this->counterpartyLogService->logError(userId: $userId, inn: $inn, message: __('responses.counterparty.da_data_error') . $response->status());
                return null;
            }

            return $this->parseResponse(response: $response, userId: $userId, inn: $inn);

        } catch (\Exception $exception) {
            $this->counterpartyLogService->logError(userId: $userId, inn: $inn, message: __('responses.counterparty.da_data_exception') . $exception->getMessage());
            return null;
        }
    }

    // Парсим результат
    private function parseResponse(Response $response, int $userId, string $inn): ?CounterpartyApiDTO
    {
        $suggestions = $response->json('suggestions');

        if (empty($suggestions)) {
            $this->counterpartyLogService->logError(userId: $userId, inn: $inn, message: __('responses.counterparty.inn_not_found'));
            return null;
        }

        if (!isset($suggestions[0]['data'])) {
            $this->counterpartyLogService->logError(userId: $userId, inn: $inn, message: __('responses.counterparty.invalid_format'));
            return null;
        }

        $data = $suggestions[0]['data'];

        return CounterpartyApiDTO::fromApiResponse(data: $data);
    }

    // Запрос на получение данных
    private function sendData(string $inn): Response
    {
        return Http::withHeaders([
            'Authorization' => 'Token ' . $this->token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->post($this->url . '/suggestions/api/4_1/rs/findById/party', ['query' => $inn]);
    }
}
