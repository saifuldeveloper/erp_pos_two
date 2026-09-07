<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRetailSecretKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $secret = $request->header('secret_key') ?? $request->header('secret-key') ?? $request->input('secret_key');

        if ($secret !== env('RETAIL_SECRET_KEY') && $secret !== config('services.avijatry.secret_key')) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid secret key'
            ], 401);
        }

        return $next($request);
    }
}
