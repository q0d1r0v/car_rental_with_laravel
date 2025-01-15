<?php
namespace App\Http\Controllers;

use App\Http\Services\Auth\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        $data = $request->only('username', 'email', 'password');

        $user = $this->authService->register($data);

        return response()->json(['user' => $user]);
    }
}
