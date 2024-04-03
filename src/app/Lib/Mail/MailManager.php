<?php

namespace App\Lib\Mail;

use App\Lib\Mail\Interfaces\IMailManager;
use App\Mail\Auth\ForgotPasswordMail;
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
