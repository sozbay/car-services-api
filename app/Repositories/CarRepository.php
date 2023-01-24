<?php

namespace App\Repositories;

use App\Models\Car;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * @method Car|null create(array $properties, bool $reselect = false)
 * @method Car|null find(int $id, array $columns = ['*'], array $with = [])
 * @method Car|null first(array $wheres, array $columns = ['*'], array $order = ['id', 'ASC'], array $with = [])
 */
class CarRepository extends AbstractRepository
{
    protected static string $model = Car::class;

    public function getCars($page = Null): LengthAwarePaginator
    {
        return Car::query()->paginate(100, page: $page);
    }

}
