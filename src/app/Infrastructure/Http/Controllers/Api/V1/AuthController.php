<?php

namespace App\Infrastructure\Http\Controllers\Api\V1;

use App\Application\Exceptions\Auth\InvalidPassword;
use App\Application\Exceptions\Auth\Password\ExpiredResetPasswordToken;
use App\Application\Exceptions\Auth\Password\ExpiredVerifyPasswordCode;
use App\Application\Exceptions\Auth\Password\InvalidResetPasswordToken;
use App\Application\Exceptions\Auth\Password\InvalidVerifyPasswordCode;
use App\Application\Exceptions\Auth\RegistrationConflict;
use Illuminate\Http\JsonResponse;
use App\Utils\Mappers\In\Auth\LoginDtoMapper;
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
use Illuminate\Http\Response;

class AuthController extends Controller
{

    public function __construct(
        private readonly IAuthService $authService
    ) {
    }

    /**
     * @param LoginRequest $loginRequest
     * @return JsonResponse
     * @throws UserNotFound
     * @throws InvalidPassword
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
     * @throws RegistrationConflict
     */
    public function register(RegisterRequest $registerRequest): JsonResponse
    {
        $registerDto = RegisterDtoMapper::fromRequest($registerRequest);
        $this->authService->register($registerDto);
        return response()->json()->setStatusCode(201);
    }

    /**
     * @return UserResource
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
     * @return Response
     * @throws UserNotFound
     */
    public function forgotPassword(ForgotPasswordRequest $forgotPasswordRequest): Response
    {
        $forgotPasswordDto = ForgotPasswordDtoMapper::fromRequest($forgotPasswordRequest);
        $this->authService->forgotPassword($forgotPasswordDto);
        return response()->noContent();
    }

    /**
     * @param VerifyPasswordCodeRequest $verifyPasswordCodeRequest
     * @return JsonResponse
     * @throws UserNotFound
     * @throws ExpiredVerifyPasswordCode
     * @throws InvalidVerifyPasswordCode
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
     * @return Response
     * @throws UserNotFound
     * @throws ExpiredResetPasswordToken
     * @throws InvalidResetPasswordToken
     */
    public function resetPassword(ResetPasswordRequest $resetPasswordRequest): Response
    {
        $resetPasswordDto = ResetPasswordDtoMapper::fromRequest($resetPasswordRequest);
        $this->authService->resetPassword($resetPasswordDto);
        return response()->noContent();
    }
}
