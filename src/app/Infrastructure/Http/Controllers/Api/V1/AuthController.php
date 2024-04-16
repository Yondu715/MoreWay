<?php

namespace App\Infrastructure\Http\Controllers\Api\V1;

use App\Application\Contracts\In\Services\Auth\IAuthService;
use Throwable;
use Illuminate\Http\JsonResponse;
use App\Infrastructure\Exceptions\ApiException;
use App\Infrastructure\Http\Controllers\Controller;
use App\Application\DTO\In\Auth\LoginDto;
use App\Application\DTO\In\Auth\RegisterDto;
use App\Infrastructure\Http\Requests\Auth\LoginRequest;
use App\Infrastructure\Http\Resources\Auth\UserResource;
use App\Application\DTO\In\Auth\Password\ResetPasswordDto;
use App\Infrastructure\Http\Requests\Auth\RegisterRequest;
use App\Application\DTO\In\Auth\Password\ForgotPasswordDto;
use App\Application\DTO\In\Auth\Password\VerifyPasswordCodeDto;
use App\Application\Exceptions\Auth\InvalidPassword;
use App\Application\Exceptions\Auth\Password\ExpiredResetPasswordToken;
use App\Application\Exceptions\Auth\Password\ExpiredVerifyPasswordCode;
use App\Application\Exceptions\Auth\Password\InvalidResetPasswordToken;
use App\Application\Exceptions\Auth\Password\InvalidVerifyPasswordCode;
use App\Application\Exceptions\Auth\RegistrationConflict;
use App\Application\Exceptions\User\UserNotFound;
use App\Infrastructure\Exceptions\InvalidToken;
use App\Infrastructure\Http\Requests\Auth\Password\ResetPasswordRequest;
use App\Infrastructure\Http\Requests\Auth\Password\ForgotPasswordRequest;
use App\Infrastructure\Http\Requests\Auth\Password\VerifyPasswordCodeRequest;

class AuthController extends Controller
{

    public function __construct(
        private readonly IAuthService $authService
    ) {}

    /**
     * @param LoginRequest $loginRequest
     * @return JsonResponse
     * @throws ApiException
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
        } catch (UserNotFound | InvalidPassword $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param RegisterRequest $registerRequest
     * @return JsonResponse
     * @throws ApiException
     */
    public function register(RegisterRequest $registerRequest): JsonResponse
    {
        try {
            $registerDto = RegisterDto::fromRequest($registerRequest);
            $this->authService->register($registerDto);
            return response()->json()->setStatusCode(201);
        } catch (RegistrationConflict $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @return UserResource
     * @throws ApiException
     */
    public function me(): UserResource
    {
        try {
            return UserResource::make(
                $this->authService->getAuthUser()
            );
        } catch (InvalidToken $e) {
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
     * @throws ApiException
     */
    public function forgotPassword(ForgotPasswordRequest $forgotPasswordRequest): void
    {
        try {
            $forgotPasswordDto = ForgotPasswordDto::fromRequest($forgotPasswordRequest);
            $this->authService->forgotPassword($forgotPasswordDto);
        } catch (UserNotFound $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param VerifyPasswordCodeRequest $verifyPasswordCodeRequest
     * @return JsonResponse
     * @throws ApiException
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
        } catch (ExpiredVerifyPasswordCode | InvalidVerifyPasswordCode $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param ResetPasswordRequest $resetPasswordRequest
     * @return void
     * @throws ApiException
     */
    public function resetPassword(ResetPasswordRequest $resetPasswordRequest): void
    {
        try {
            $resetPasswordDto = ResetPasswordDto::fromRequest($resetPasswordRequest);
            $this->authService->resetPassword($resetPasswordDto);
        } catch (InvalidResetPasswordToken | ExpiredResetPasswordToken $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }
}
