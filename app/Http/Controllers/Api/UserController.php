<?php

namespace App\Http\Controllers\Api;

use App\Application\User\CreateUserService;
use App\Application\User\GetUserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private CreateUserService $createUserService,
        private GetUserService $getUserService
    ) {}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
        ]);

        $user = $this->createUserService->execute(
            $validated['name'],
            $validated['email']
        );

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function show(int $id)
    {
        $user = $this->getUserService->execute($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }
}
