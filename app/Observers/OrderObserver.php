<?php

namespace App\Observers;

use App\Models\Balance;
use App\Models\Orders;

class OrderObserver
{
    public function created(Orders $order)
    {
        Balance::query()->create([
            'user_id' => $order->user_id,
            'balance' => $order->service->price,
            'type' => '-'
        ])->save();
    }
}
