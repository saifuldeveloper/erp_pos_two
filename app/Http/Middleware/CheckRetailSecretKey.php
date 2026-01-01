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
        $secret = $request->input('secret_key');

        if ($secret !== env('RETAIL_SECRET_KEY')) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid secret key'
            ], 401);
        }

        return $next($request);
    }
}
