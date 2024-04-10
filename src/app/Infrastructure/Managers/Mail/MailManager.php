<?php

namespace App\Infrastructure\Managers\Mail;

use App\Application\Contracts\Out\InfrastructureManagers\IMailManager;
use App\Infrastructure\Managers\Mail\Auth\ForgotPasswordMail;
use Illuminate\Support\Facades\Mail;

class MailManager implements IMailManager
{
    /**
     * @param string $email
     * @param string $resetCode
     * @return void
     */
    public function sendResetCode(string $email, string $resetCode): void
    {
        Mail::to($email)->send(new ForgotPasswordMail($resetCode));
    }
}
