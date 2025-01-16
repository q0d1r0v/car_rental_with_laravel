<?php
namespace App\Http\Controllers;

use App\Http\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class UserController extends BaseController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function loadUsers(Request $request) {
        return $this->userService->loadUsers($request);
    }
}
