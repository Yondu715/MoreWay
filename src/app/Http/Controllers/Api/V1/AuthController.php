<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\Auth\LoginDto;
use App\DTO\Auth\RegisterDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\UserResource;
use App\Services\Auth\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * @param AuthService $authService
     */
    public function __construct(private readonly AuthService $authService){}

    /**
     * @param LoginRequest $loginRequest
     * @return JsonResponse
     * @throws Exception
     */
    public function login(LoginRequest $loginRequest): JsonResponse
    {
        $inLoginDto = LoginDto::fromRequest($loginRequest);

        return response()->json(['data' => [
            'accessToken' => $this->authService->login($inLoginDto)
            ]
        ]);
    }

    /**
     * @param RegisterRequest $registerRequest
     * @return void
     * @throws Exception
     */
    public function register(RegisterRequest $registerRequest): void
    {
        $registerDto = RegisterDto::fromRequest($registerRequest);

        $this->authService->register($registerDto);
    }

    /**
     * @return UserResource
     * @throws Exception
     */
    public function me(): UserResource
    {
        return UserResource::make($this->authService->getAuthUser());
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        $this->authService->logout();
    }

    /**
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return response()->json(['data' => [
            'accessToken' => $this->authService->refresh()
            ]
        ]);
    }
}
