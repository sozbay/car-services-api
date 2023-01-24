<?php

namespace App\Repositories;

use App\Models\Orders;
use App\Models\Services;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

/**
 * @method Services|null create(array $properties, bool $reselect = false)
 * @method Services|null find(int $id, array $columns = ['*'], array $with = [])
 * @method Services|null first(array $wheres, array $columns = ['*'], array $order = ['id', 'ASC'], array $with = [])
 */
class ServiceRepository extends AbstractRepository
{
    protected static string $model = Services::class;

    /**
     * @return array
     */
    public function getServices(): array
    {
        return Cache::remember(Auth::id() . 'get_services_key', ENV('SESSION_LIFETIME', 86000), function () {
            return Services::with('currency:id,name,symbol')
                ->get(['id', 'name', 'price', 'currency_id', 'service_type'])
                ->toArray();
        });
    }

}
