<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\Counterparty\CounterpartyDTO;
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

    /**
     * @OA\Get(
     *     path="/counterparties",
     *     tags={"Counterparties"},
     *     summary="Получить контрагентов",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="perPage",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Список контрагентов"),
     *     @OA\Response(response=401, description="Неавторизован")
     * )
     */

    public function index(PaginateRequest $request): JsonResponse
    {
        $counterparties = $this->counterpartyRepository->getAll(filters: $request->validated());

        return $this->success(success: true, message: null, data: $counterparties, code: JsonResponse::HTTP_OK);
    }


    /**
     * @OA\Post(
     *     path="/counterparty",
     *     tags={"Counterparties"},
     *     summary="Добавить контрагента",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"inn"},
     *             @OA\Property(property="inn", type="string", example="7736207543")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Контрагент добавлен"),
     *     @OA\Response(response=401, description="Неавторизован"),
     *     @OA\Response(response=404, description="Контрагент не найден"),
     *     @OA\Response(response=422, description="Ошибка валидации")
     * )
     */

    public function store(CreateCounterpartyRequest $request): JsonResponse
    {
        $dto = CounterpartyDTO::fromRequest(userId: auth()->id(), validated: $request->validated());

        $counterparty = $this->counterpartyService->create($dto);

        if (!$counterparty->success) {
            return $this->message(success: false, message: $counterparty->message, code: $counterparty->code);
        }

        return $this->success(success: true, message: 'ИНН успешно добавлен для контрагента.', data: $counterparty->data, code: JsonResponse::HTTP_CREATED);
    }
}
