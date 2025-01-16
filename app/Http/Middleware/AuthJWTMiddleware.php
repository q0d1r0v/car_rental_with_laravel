<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthJWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // Authorization header'dan Bearer tokenni olish
            $token = $request->header('Authorization');

            if (!$token || !str_starts_with($token, 'Bearer ')) {
                return response()->json(['error' => 'Token not provided'], 401);
            }

            $token = str_replace('Bearer ', '', $token);

            // Tokenni tekshirish va yechish
            $user = JWTAuth::setToken($token)->authenticate();

            if (!$user) {
                return response()->json(['error' => 'User not found'], 401);
            }

            // Foydalanuvchini request ob'ektiga qo'shish
            $request->merge(['user' => $user]);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token is invalid or expired'], 401);
        }

        return $next($request);
    }
}
