<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\BalanceRequest;
use App\Models\User;
use App\Repositories\BalanceRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BalanceController extends BaseApiController
{
    protected BalanceRepository $repository;

    public function __construct(BalanceRepository $balanceRepository)
    {
        $this->repository = $balanceRepository;
    }

    public function addBalance(BalanceRequest $request): Response
    {
        $balance = $request->get('balance');
        $userId = Auth::id();
        DB::beginTransaction();
        try {
            $this->repository->create(
                ['user_id' => $userId,
                    'balance' => $balance,
                    'type' => '+'
                ]);
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            return $this->errorResponse("An Error Occurred");
        }
        return $this->successResponse(['user' => User::query()->where('id', $userId)->with('balance')->first()]);
    }
}
