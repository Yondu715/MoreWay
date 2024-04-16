<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Middleware;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Managers\Token\ITokenManager;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Exceptions\Forbidden;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserId
{
    public function __construct(
        private readonly ITokenManager $tokenManager
    ) {
    }

    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     * @throws Exception
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userId = $request->userId ?? $request->route('userId');
        if ($this->tokenManager->getAuthUser()->id !== (int)$userId) {
            throw new Forbidden();
        }
        return $next($request);
    }
}
