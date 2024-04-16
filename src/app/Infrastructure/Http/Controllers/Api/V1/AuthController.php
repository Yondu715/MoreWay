<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Controllers\Api\V1;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\In\Services\Auth\IAuthService;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\Auth\LoginDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\Auth\Password\ForgotPasswordDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\Auth\Password\ResetPasswordDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\Auth\Password\VerifyPasswordCodeDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\Auth\RegisterDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Exceptions\ApiException;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Controllers\Controller;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Requests\Auth\LoginRequest;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Requests\Auth\Password\ForgotPasswordRequest;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Requests\Auth\Password\ResetPasswordRequest;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Requests\Auth\Password\VerifyPasswordCodeRequest;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Requests\Auth\RegisterRequest;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Resources\Auth\UserResource;
use Illuminate\Http\JsonResponse;
use Throwable;

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
        } catch (Throwable $th) {
            throw new ApiException($th->getMessage(), $th->getCode());
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
        } catch (Throwable $th) {
            throw new ApiException($th->getMessage(), $th->getCode());
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
        } catch (Throwable $th) {
            throw new ApiException($th->getMessage(), $th->getCode());
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
        } catch (Throwable $th) {
            throw new ApiException($th->getMessage(), $th->getCode());
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
        } catch (Throwable $th) {
            throw new ApiException($th->getMessage(), $th->getCode());
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
        } catch (Throwable $th) {
            throw new ApiException($th->getMessage(), $th->getCode());
        }
    }
}
