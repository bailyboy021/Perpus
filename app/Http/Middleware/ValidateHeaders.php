<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        // Validasi header
        if ($request->header('User-Id') !== 'ifabula' || $request->header('Scope') !== 'user') {
            return response()->json([
                'responseCode' => 401,
                'responseMessage' => 'UNAUTHORIZED'
            ], 401);
        }

        return $next($request);
    }
}
