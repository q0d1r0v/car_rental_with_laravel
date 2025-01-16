<?php

namespace App\Http\Services\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;

class UserService
{
    public function loadUsers(Request $request)
{
    try {
        $page = $request->input('page', 1);
        $perPage = 15;
        $users = User::paginate($perPage, ['*'], 'page', $page);
        return response()->json([
            'data' => $users,
            'links' => [
                'first' => $users->url(1),
                'prev' => $users->previousPageUrl(),
                'next' => $users->nextPageUrl(),
                'last' => $users->url($users->lastPage())
            ]
        ], Response::HTTP_OK);
    } catch (ValidationException $e) {
        throw $e;
    }
}

}
