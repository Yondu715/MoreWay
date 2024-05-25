<?php

namespace App\Infrastructure\Enums\Auth;

enum AuthGuard: string
{
    case API = 'api';
    case WEB = 'web';
}