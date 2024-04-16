<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Managers\Mail;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Managers\Mail\IMailManager;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Managers\Mail\Auth\ForgotPasswordMail;
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
