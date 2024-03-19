<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiValidation
{
    public function handle($request, Closure $next)
    {
        // Check if the request has a bearer token
        if (!$request->bearerToken()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            // Attempt to decode the JWT token
            $user = JWTAuth::parseToken()->authenticate();
            // Get the decoded token payload (claims)
            $payload = JWTAuth::manager()->decode(JWTAuth::getToken());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Set the authenticated user and payload on the request
        $request->merge(['user' => $user]);
        $request->merge(['payload' => $payload]);

        return $next($request);
    }
}
