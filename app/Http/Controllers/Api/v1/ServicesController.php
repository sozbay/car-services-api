<?php

namespace App\Http\Controllers\Api\v1;

use App\Repositories\ServiceRepository;
use Illuminate\Http\Response;

class ServicesController extends BaseApiController
{
    protected ServiceRepository $repository;

    /**
     * @param ServiceRepository $repository
     */
    public function __construct(ServiceRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Response
     */
    public function getServices(): Response
    {
        return $this->successResponse($this->repository->getServices());
    }
}

