<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\OrderRequest;
use App\Models\Services;
use App\Repositories\OrderRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends BaseApiController
{

    protected OrderRepository $repository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->repository = $orderRepository;
    }

    public function createOrder(OrderRequest $request): Response
    {
        $data = $request->validated();
        $service = Services::query()->where('id', '=', $data['service_id'])->first();
        $totalBalance = Auth::user()->balanceCalc();
        $userId = Auth::id();

        if ($totalBalance >= $service->price) {

            DB::beginTransaction();
            try {
                $this->repository->create([
                    'user_id' => $userId,
                    'service_id' => $data['service_id'],
                    'car_model_id' => $data['car_model_id']
                ]);

                DB::commit();

            } catch (Exception $exception) {
                DB::rollBack();
                return $this->errorResponse("An Error Occurred");
            }

            return $this->successResponse('Your order has been created');
        }

        return $this->errorResponse("Not Enough Balance | Balance:$totalBalance$ - Service Price:$service->price$", 402);
    }

    public function getOrders(Request $request): Response
    {
        $serviceType = $request->get('service_type');
        $carBrand = $request->get('car_brand');
        $order = $this->repository->getOrders($serviceType, $carBrand);
        return $this->successResponse($order);
    }
}
