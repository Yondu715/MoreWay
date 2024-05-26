<?php

namespace App\Infrastructure\Http\Controllers\Api\V1;

use Illuminate\Http\JsonResponse;
use App\Utils\Mappers\In\Auth\LoginDtoMapper;
use App\Infrastructure\Exceptions\ApiException;
use App\Utils\Mappers\In\Auth\RegisterDtoMapper;
use App\Application\Exceptions\User\UserNotFound;
use App\Infrastructure\Http\Controllers\Controller;
use App\Infrastructure\Http\Requests\Auth\LoginRequest;
use App\Infrastructure\Http\Resources\User\UserResource;
use App\Infrastructure\Http\Requests\Auth\RegisterRequest;
use App\Application\Contracts\In\Services\Auth\IAuthService;
use App\Utils\Mappers\In\Auth\Password\ResetPasswordDtoMapper;
use App\Utils\Mappers\In\Auth\Password\ForgotPasswordDtoMapper;
use App\Utils\Mappers\In\Auth\Password\VerifyPasswordCodeDtoMapper;
use App\Infrastructure\Http\Requests\Auth\Password\ResetPasswordRequest;
use App\Infrastructure\Http\Requests\Auth\Password\ForgotPasswordRequest;
use App\Infrastructure\Http\Requests\Auth\Password\VerifyPasswordCodeRequest;

class AuthController extends Controller
{

    public function __construct(
        private readonly IAuthService $authService
    ) {
    }

    /**
     * @param LoginRequest $loginRequest
     * @return JsonResponse
     * @throws ApiException
     */
    public function login(LoginRequest $loginRequest): JsonResponse
    {
        $inLoginDto = LoginDtoMapper::fromRequest($loginRequest);

        return response()->json([
            'data' => [
                'accessToken' => $this->authService->login($inLoginDto)
            ]
        ]);
    }

    /**
     * @param RegisterRequest $registerRequest
     * @return JsonResponse
     * @throws ApiException
     */
    public function register(RegisterRequest $registerRequest): JsonResponse
    {
        $registerDto = RegisterDtoMapper::fromRequest($registerRequest);
        $this->authService->register($registerDto);
        return response()->json()->setStatusCode(201);
    }

    /**
     * @return UserResource
     * @throws ApiException
     */
    public function me(): UserResource
    {
        return UserResource::make(
            $this->authService->getAuthUser()
        );
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
            'data' => [
                'accessToken' => $this->authService->refresh()
            ]
        ]);
    }

    /**
     * @param ForgotPasswordRequest $forgotPasswordRequest
     * @return void
     * @throws ApiException
     */
    public function forgotPassword(ForgotPasswordRequest $forgotPasswordRequest): void
    {
        $forgotPasswordDto = ForgotPasswordDtoMapper::fromRequest($forgotPasswordRequest);
        $this->authService->forgotPassword($forgotPasswordDto);
    }

    /**
     * @param VerifyPasswordCodeRequest $verifyPasswordCodeRequest
     * @return JsonResponse
     * @throws ApiException
     * @throws UserNotFound
     */
    public function verifyPasswordCode(VerifyPasswordCodeRequest $verifyPasswordCodeRequest): JsonResponse
    {
        $verifyPasswordCodeDto = VerifyPasswordCodeDtoMapper::fromRequest($verifyPasswordCodeRequest);
        return response()->json([
            'data' => [
                'resetPasswordToken' => $this->authService->verifyPasswordCode($verifyPasswordCodeDto)
            ]
        ]);
    }

    /**
     * @param ResetPasswordRequest $resetPasswordRequest
     * @return void
     * @throws ApiException
     * @throws UserNotFound
     */
    public function resetPassword(ResetPasswordRequest $resetPasswordRequest): void
    {
        $resetPasswordDto = ResetPasswordDtoMapper::fromRequest($resetPasswordRequest);
        $this->authService->resetPassword($resetPasswordDto);
    }
}
