<?php

namespace App\Lib\Mail;

use App\Mail\Auth\ForgotPasswordMail;
use Illuminate\Support\Facades\Mail;

class MailManager
{
    /**
     * @param string $email
     * @param string $resetCode
     * @return void
     */
    public function send(string $email, string $resetCode): void
    {
        Mail::to($email)->send(new ForgotPasswordMail($resetCode));
    }
}
