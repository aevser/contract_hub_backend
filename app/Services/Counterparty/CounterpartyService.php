<?php

namespace App\Services\Counterparty;

use App\Models\Counterparty\Counterparty;
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
    public function create(string $inn): array
    {
        $data = $this->getCompanyByInn(inn: $inn);

        if (!$data) { return $this->errorResponse(message: 'Не удалось получить данные по ИНН.'); }

        $counterparty = $this->createCounterparty(inn: $inn, data: $data);

        $this->counterpartyLogService->logSuccess(counterpartyId: $counterparty->id, message: 'Данные успешно получены.');

        return $this->successResponse(counterparty: $counterparty);
    }

    // Сохраняем в БД
    private function createCounterparty(string $inn, array $data): Counterparty
    {
        return $this->counterpartyRepository->create(
            userId: auth()->id(),
            inn: $inn,
            name: $data['name'],
            ogrn: $data['ogrn'],
            address: $data['address']
        );
    }

    // Получение и обработка результата
    private function getCompanyByInn(string $inn): ?array
    {
        try {
            $response = $this->sendData(inn: $inn);

            if (!$response->successful()) {
                $this->counterpartyLogService->logError(message: 'Ошибка DaData. Статус: ' . $response->status());
                return null;
            }

            return $this->parseResponse(response: $response, inn: $inn);

        } catch (\Exception $exception) {
            $this->counterpartyLogService->logError(message: 'Исключение при запросе DaData: ' . $exception->getMessage());
            return null;
        }
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

    // Парсим результат
    private function parseResponse(Response $response, string $inn): ?array
    {
        $suggestions = $response->json('suggestions');

        if (empty($suggestions)) {
            $this->counterpartyLogService->logError(message: 'Данные по ИНН: ' . $inn . ' не найдены.');
            return null;
        }

        $data = $suggestions[0]['data'];

        return [
            'name' => $data['name']['short_with_opf'] ?? null,
            'ogrn' => $data['ogrn'] ?? null,
            'address' => $data['address']['unrestricted_value'] ?? null,
        ];
    }

    private function successResponse(Counterparty $counterparty): array
    {
        return ['success' => true, 'data' => $counterparty];
    }

    private function errorResponse(string $message): array
    {
        return ['success' => false, 'message' => $message, 'code' => 404];
    }
}
