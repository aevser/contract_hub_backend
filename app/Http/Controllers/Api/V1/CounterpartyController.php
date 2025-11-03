<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Counterparty\CreateCounterpartyRequest;
use App\Http\Requests\V1\PaginateRequest;
use App\Repositories\Counterparty\CounterpartyRepository;
use App\Services\Counterparty\CounterpartyService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class CounterpartyController extends Controller
{
    use ApiResponse;

    public function __construct(private CounterpartyRepository $counterpartyRepository, private CounterpartyService $counterpartyService){}

    public function index(PaginateRequest $request): JsonResponse
    {
        $counterparties = $this->counterpartyRepository->getAll(filters: $request->validated());

        return $this->success(success: true, message: null, data: $counterparties, code: JsonResponse::HTTP_OK);
    }

    public function store(CreateCounterpartyRequest $request): JsonResponse
    {
        $counterparty = $this->counterpartyService->create($request->validated('inn'));

        if (!$counterparty['success']) {
            return $this->message(success: false, message: $counterparty['message'], code: $counterparty['code']);
        }

        return $this->success(success: true, message: 'Инн успешно добавлен для контрагента.', data: $counterparty['data'], code: JsonResponse::HTTP_CREATED);
    }
}
