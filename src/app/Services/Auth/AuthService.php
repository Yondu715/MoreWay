<?php

namespace App\Services\Auth;

use App\DTO\In\Auth\LoginDto;
use App\DTO\In\Auth\RegisterDto;
use App\DTO\Out\Auth\UserDto;
use App\Exceptions\Auth\InvalidPassword;
use App\Exceptions\Auth\RegistrationConflict;
use App\Lib\Token\TokenManager;
use App\Repositories\User\Interfaces\IUserRepository;
use App\Services\Auth\Interfaces\IAuthService;
use Exception;
use Illuminate\Support\Facades\Hash;

class AuthService implements IAuthService
{

    public function __construct(
        private readonly TokenManager $tokenManager,
        private readonly IUserRepository $userRepository
    ) {
    }
    /**
     * @param LoginDto $loginDto
     * @return string
     * @throws Exception
     */
    public function login(LoginDto $loginDto): string
    {
        $user = $this->userRepository->findByEmail($loginDto->email);

        if (!Hash::check($loginDto->password, $user->password)) {
            throw new InvalidPassword();
        }

        return $this->tokenManager->getNewToken($user);
    }

    /**
     * @param RegisterDto $registerDto
     * @return void
     * @throws Exception
     */
    public function register(RegisterDto $registerDto): void
    {
        if ($this->userRepository->findByEmail($registerDto->email)) {
            throw new RegistrationConflict();
        }

        $this->userRepository->create([
            'name' => $registerDto->name,
            'email' => $registerDto->email,
            'password' => $registerDto->password
        ]);
    }

    /**
     * @return UserDto
     * @throws Exception
     */
    public function getAuthUser(): UserDto
    {
        return UserDto::fromUserModel($this->tokenManager->getAuthUser());
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        $this->tokenManager->destroyToken();
    }

    /**
     * @return string
     */
    public function refresh(): string
    {
        return $this->tokenManager->refreshToken();
    }
}
