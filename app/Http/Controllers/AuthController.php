<?php
namespace App\Http\Controllers;

use App\Http\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class AuthController extends BaseController
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request) {
        $data = $request->only(["username","password"]);

        return $this->authService->login($data);
    }

    public function register(Request $request)
    {
        $data = $request->only('username', 'email', 'password');


        return $this->authService->register($data);
    }
}
