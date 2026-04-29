<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Services\Auth\AuthService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends Controller
{
    /**
     * Register User.
     * @unauthenticated
     */
    public function store(UserRegisterRequest $request, AuthService $authService): JsonResponse
    {
        $dto = $request->validated();

        $user = $authService->store($dto);

        return ApiResponse::success($user, 'User Registered Successfully!', 201);
    }


    /**
     * Login User
     * @unauthenticated
     */
    public function login(UserLoginRequest $request, AuthService $authService): JsonResponse
    {
        $dto = $request->validated();

        $resp = $authService->login($dto);

        return ApiResponse::success(
            [
                'user' => $resp['user'],
                'token' => $resp['token'],
            ],
            'User Loggedin Successfully',
            200
        );
    }

    /**
     * Get Me
     */
    public function show(): JsonResponse
    {
        $user = Auth::user();

        return ApiResponse::success($user, 'Details Fetched Successfully.', 200);
    }

    /**
     * User Logout
     */
    public function logout()
    {

        Auth::user()->currentAccessToken()->delete();

        return ApiResponse::success(null, 'User Logout Successfully.', 200);
    }
}
