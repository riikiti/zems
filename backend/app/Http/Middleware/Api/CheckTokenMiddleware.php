<?php

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return match (true) {
            !request()->bearerToken() => response()->json([
                'status' => 404,
                'message' => 'token dont enter'
            ],404),
            auth()->user() == null => response()->json([
                'status' => 401,
                'message' => 'Unauthorized'
            ],401),
            default => $next($request),
        };
    }
}
