<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponse
{
    public function success(bool $success, ?string $message, mixed $data, int $code): JsonResponse
    {
        $response = ['success' => $success];

        if ($message) { $response['message'] = $message; }

        $formattedData = $this->formatResponseData($data);

        if (is_array($formattedData) && isset($formattedData['pagination'])) {
            $response['data'] = $formattedData['data'];
            $response['pagination'] = $formattedData['pagination'];
        } else {
            $response['data'] = $formattedData;
        }

        return response()->json($response, $code);
    }

    public function auth(bool $success, User $user, string $token, int $code): JsonResponse
    {
        return response()->json(['success' => $success, 'data' => ['user' => $user, 'token' => $token]], $code);
    }

    public function message(bool $success, string $message, int $code): JsonResponse
    {
        return response()->json(['success' => $success, 'message' => $message], $code);
    }

    private function formatResponseData(mixed $data): mixed
    {
        if ($this->isResourceCollectionWithPaginator($data)) { return $this->formatResourceCollectionWithPagination($data); }

        if ($data instanceof LengthAwarePaginator) { return $this->formatPaginatorData($data); }

        return $data;
    }

    private function isResourceCollectionWithPaginator(mixed $data): bool
    {
        return $data instanceof AnonymousResourceCollection && $data->resource instanceof LengthAwarePaginator;
    }

    private function formatResourceCollectionWithPagination(AnonymousResourceCollection $data): mixed
    {
        $paginator = $data->resource;

        $items = $data->toArray(request());

        if (count($items) === 1) { return $items[0]; }

        return ['data' => $items, 'pagination' => $this->getPaginationMeta($paginator)];
    }

    private function formatPaginatorData(LengthAwarePaginator $paginator): mixed
    {
        $items = $paginator->items();

        if (count($items) === 1) { return $items[0]; }

        return ['data' => $items, 'pagination' => $this->getPaginationMeta($paginator)];
    }

    private function getPaginationMeta(LengthAwarePaginator $paginator): array
    {
        return [
            'total' => $paginator->total(),
            'currentPage' => $paginator->currentPage(),
            'perPage' => $paginator->perPage()
        ];
    }
}
