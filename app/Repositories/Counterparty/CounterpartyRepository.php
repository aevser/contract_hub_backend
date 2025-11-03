<?php

namespace App\Repositories\Counterparty;

use App\Constants\PaginationAndSort;
use App\Models\Counterparty\Counterparty;
use Illuminate\Pagination\LengthAwarePaginator;

class CounterpartyRepository
{
    private const string RELATIONS = 'user';

    public function __construct(private Counterparty $counterparty){}

    public function getAll(array $filters): LengthAwarePaginator
    {
        return $this->counterparty->query()
            ->with(self::RELATIONS)
            ->where('user_id', auth()->id())
            ->orderBy(PaginationAndSort::SORT_COLUMN, PaginationAndSort::SORT_DIRECTION_DESC)
            ->paginate($filters['perPage'] ?? PaginationAndSort::PAGINATION_PER_PAGE);
    }

    public function create(int $userId, string $inn, string $name, string $ogrn, string $address): Counterparty
    {
        $counterparty = $this->counterparty->query()->create(['user_id' => $userId, 'inn' => $inn, 'name' => $name, 'ogrn' => $ogrn, 'address' => $address]);

        return $counterparty->fresh(self::RELATIONS);
    }
}
