<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class BaseApiController extends Controller
{
    protected function successResponse($data): Response
    {
        $obj = [
            'success' => true,
            'errorMessage' => null,
            'balance' => Auth::check() ? User::find(Auth::id())->balanceCalc() : 0,
            'data' => $data
        ];
        return response($obj, 200);
    }

    protected function errorResponse($errorMessage, $status = 400): Response
    {
        $obj = [
            'success' => false,
            'errorMessage' => $errorMessage,
        ];
        return response($obj, $status);
    }
}
