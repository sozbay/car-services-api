<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Balance;
use App\Models\User;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use function data_get;

class AuthController extends BaseApiController
{
    public function register(RegisterRequest $request): Response
    {
        $data = $request->validated();

        $firstName = data_get($data, 'first_name');
        $lastName = data_get($data, 'last_name');
        $email = data_get($data, 'email');
        $password = data_get($data, 'password');

        DB::beginTransaction();
        try {
            $user = new User([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'password' => Hash::make($password)
            ]);
            $user->save();
            Balance::query()->create([
                'user_id' => $user->id
            ]);
            $token = Auth::login($user);
            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            return $this->errorResponse("An Error Occurred");
        }

        return $this->successResponse(['user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]]);

    }

    public function login(LoginRequest $request): Response
    {
        $data = $request->validated();
        $token = Auth::attempt($data);
        if ($token) {
            $user = Auth::user();

            return $this->successResponse(['user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]]);
        } else {
            
            return $this->errorResponse([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }
    }

    public function logout(): Response
    {
        Auth::logout();
        return $this->successResponse([
            'success' => true,
            'message' => 'You have successfully logout!'
        ]);

    }
}
