<?php

namespace App\Infrastructure\Http\Controllers\Api\V1;

use App\Application\Contracts\In\Services\IAuthService;
use App\Application\DTO\In\Auth\LoginDto;
use App\Application\DTO\In\Auth\Password\ForgotPasswordDto;
use App\Application\DTO\In\Auth\Password\ResetPasswordDto;
use App\Application\DTO\In\Auth\Password\VerifyPasswordCodeDto;
use App\Application\DTO\In\Auth\RegisterDto;
use App\Infrastructure\Exceptions\ApiException;
use App\Infrastructure\Http\Controllers\Controller;
use App\Infrastructure\Http\Requests\Auth\LoginRequest;
use App\Infrastructure\Http\Requests\Auth\Password\ForgotPasswordRequest;
use App\Infrastructure\Http\Requests\Auth\Password\ResetPasswordRequest;
use App\Infrastructure\Http\Requests\Auth\Password\VerifyPasswordCodeRequest;
use App\Infrastructure\Http\Requests\Auth\RegisterRequest;
use App\Infrastructure\Http\Resources\Auth\UserResource;
use Exception;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{

    public function __construct(
        private readonly IAuthService $authService
    ) {}

    /**
     * @param LoginRequest $loginRequest
     * @return JsonResponse
     * @throws Exception
     */
    public function login(LoginRequest $loginRequest): JsonResponse
    {
        try {
            $inLoginDto = LoginDto::fromRequest($loginRequest);

            return response()->json([
                'data' => [
                    'accessToken' => $this->authService->login($inLoginDto)
                ]
            ]);
        } catch (Exception $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param RegisterRequest $registerRequest
     * @return JsonResponse
     * @throws Exception
     */
    public function register(RegisterRequest $registerRequest): JsonResponse
    {
        try {
            $registerDto = RegisterDto::fromRequest($registerRequest);
            $this->authService->register($registerDto);
            return response()->json()->setStatusCode(201);
        } catch (Exception $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @return UserResource
     * @throws Exception
     */
    public function me(): UserResource
    {
        try {
            return UserResource::make(
                $this->authService->getAuthUser()
            );
        } catch (Exception $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
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
     * @throws Exception
     */
    public function forgotPassword(ForgotPasswordRequest $forgotPasswordRequest): void
    {
        try {
            $forgotPasswordDto = ForgotPasswordDto::fromRequest($forgotPasswordRequest);
            $this->authService->forgotPassword($forgotPasswordDto);
        } catch (Exception $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param VerifyPasswordCodeRequest $verifyPasswordCodeRequest
     * @return JsonResponse
     * @throws Exception
     */
    public function verifyPasswordCode(VerifyPasswordCodeRequest $verifyPasswordCodeRequest): JsonResponse
    {
        try {
            $verifyPasswordCodeDto = VerifyPasswordCodeDto::fromRequest($verifyPasswordCodeRequest);
            return response()->json([
                'data' => [
                    'resetPasswordToken' => $this->authService->verifyPasswordCode($verifyPasswordCodeDto)
                ]
            ]);
        } catch (Exception $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param ResetPasswordRequest $resetPasswordRequest
     * @return void
     * @throws Exception
     */
    public function resetPassword(ResetPasswordRequest $resetPasswordRequest): void
    {
        try {
            $resetPasswordDto = ResetPasswordDto::fromRequest($resetPasswordRequest);
            $this->authService->resetPassword($resetPasswordDto);
        } catch (Exception $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }
}
