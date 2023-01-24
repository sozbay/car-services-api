<?php

namespace App\Http\Controllers\Api\v1;

use App\Repositories\CarRepository;
use Exception;
use Illuminate\Http\Request;

class CarController extends BaseApiController
{
    protected CarRepository $repository;

    public function __construct(CarRepository $carRepository)
    {
        $this->repository = $carRepository;
    }

    public function getCars(Request $request)
    {
        $page = $request->get('page') ?? 1;
        try {
            $result = [
                'data' => $this->repository->getCars()->items(),
                'currentPage' => $page,
                'lastPage' => $this->repository->getCars($page)->lastPage()
            ];

            return $this->successResponse($result);

        } catch (Exception $exception) {
            return $this->errorResponse("An Error Occurred");
        }

    }
}
