<?php

namespace App\Application\Contracts\Out\InfrastructureManagers;

interface IMailManager
{
    /**
     * @param string $email
     * @param string $resetCode
     * @return void
     */
    public function sendResetCode(string $email, string $resetCode): void;
}
