<?php

namespace App\Http\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class AuthService
{
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
