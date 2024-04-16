<?php

namespace App\Application\Contracts\Out\Managers\Mail;

interface IMailManager
{
    /**
     * @param string $email
     * @param string $resetCode
     * @return void
     */
    public function sendResetCode(string $email, string $resetCode): void;
}
