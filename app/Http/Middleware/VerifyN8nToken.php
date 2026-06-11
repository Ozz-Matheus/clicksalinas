<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyN8nToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $expectedToken = config('services.n8n.token');

        // Si no hay token configurado o no coincide, bloqueamos la petición
        if (empty($expectedToken) || $request->bearerToken() !== $expectedToken) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        return $next($request);
    }
}
