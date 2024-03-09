<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\Auth\LoginDto;
use App\DTO\Auth\RegisterDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\AuthResource;
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
     * @return AuthResource
     * @throws Exception
     */
    public function login(LoginRequest $loginRequest): AuthResource
    {
        $inLoginDto = LoginDto::fromRequest($loginRequest);
        $outAuthDto = $this->authService->login($inLoginDto);

        return AuthResource::make($outAuthDto);
    }

    /**
     * @param RegisterRequest $registerRequest
     * @return AuthResource
     * @throws Exception
     */
    public function register(RegisterRequest $registerRequest): AuthResource
    {
        $registerDto = RegisterDto::fromRequest($registerRequest);
        $outAuthDto = $this->authService->register($registerDto);

        return AuthResource::make($outAuthDto);
    }

    /**
     * @return UserResource
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
        return response()->json([
            'accessToken' => $this->authService->refresh()
        ]);
    }
}
