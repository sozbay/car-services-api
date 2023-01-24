<?php

namespace App\Repositories;

use App\Models\Orders;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

/**
 * @method Orders|null create(array $properties, bool $reselect = false)
 * @method Orders|null find(int $id, array $columns = ['*'], array $with = [])
 * @method Orders|null first(array $wheres, array $columns = ['*'], array $order = ['id', 'ASC'], array $with = [])
 */
class OrderRepository extends AbstractRepository
{
    protected static string $model = Orders::class;

    public function getOrders($serviceType, $carBrand)
    {

        return Orders::query()
            ->with('service:id,name,price,service_type,currency_id')
            ->with('car')
            ->where('user_id', '=', Auth::id())
            ->whereHas('service', function ($q) use ($serviceType) {
                if ($serviceType) {
                    $q->where('service_type', "=", $serviceType);
                }
            })
            ->whereHas('car', function ($q) use ($carBrand) {
                if ($carBrand) {
                    $q->where('brand', "=", $carBrand);
                }
            })
            ->get();
    }

}
