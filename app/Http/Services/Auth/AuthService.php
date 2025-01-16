<?php

namespace App\Http\Services\Auth;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function login(array $data) {
        try {
            $user = User::where('username', $data['username'])->first();
        
            if (!$user) {
                throw new HttpResponseException(response()->json([
                    'message' => 'User not found'
                ], Response::HTTP_NOT_FOUND));
            }
        
            if (!Hash::check($data['password'], $user->password)) {
                throw new HttpResponseException(response()->json([
                    'message' => 'Invalid password'
                ], Response::HTTP_UNAUTHORIZED));
            }
        
            $token = JWTAuth::claims([
                'exp' => Carbon::now()->addHours(23)->timestamp,
            ])->fromUser($user);
        
            return response()->json([
                'token' => $token,
                'user' => $user->makeHidden('password')
            ], Response::HTTP_OK);
        
        } catch (ValidationException $err) {
            throw $err;
        }
    }

    public function register(array $data)
    {
        try {
            if (User::where('email', $data['email'])->exists()) {
                throw new HttpResponseException(response()->json([
                    'message' => 'Email already exists'
                ], Response::HTTP_BAD_REQUEST));
            }

            if (User::where('username', $data['username'])->exists()) {
                throw new HttpResponseException(response()->json([
                    'message' => 'Username already exists'
                ], Response::HTTP_BAD_REQUEST));
            }

            $user = User::create([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            return response()->json([
                'data' => $user->makeHidden('password')
            ], Response::HTTP_CREATED);

        } catch (ValidationException $e) {
            throw $e;
        }
    }
}
