<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Managers\Mail\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $resetCode;

    /**
     * Create a new message instance.
     */
    public function __construct(string $resetCode)
    {
        $this->resetCode = $resetCode;
    }

    /**
     * Get the message content definition.
     */
    public function build()
    {
        return $this->subject('Сброс пароля')->view('emails.password-reset');
    }
}
