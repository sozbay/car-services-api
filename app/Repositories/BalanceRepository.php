<?php

namespace App\Repositories;

use App\Models\Balance;
use Illuminate\Support\Facades\Cache;

/**
 * @method Balance|null create(array $properties, bool $reselect = false)
 * @method Balance|null find(int $id, array $columns = ['*'], array $with = [])
 * @method Balance|null first(array $wheres, array $columns = ['*'], array $order = ['id', 'ASC'], array $with = [])
 */
class BalanceRepository extends AbstractRepository
{
    protected static string $model = Balance::class;

}
