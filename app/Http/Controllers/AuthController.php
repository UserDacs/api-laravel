<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = $this->authService->register($validatedData);

        if ($user instanceof JsonResponse) {
            return $user; // Return conflict response if email exists
        }
        return message($user, 'User registered successfully', 201);
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        return $this->authService->login($validatedData);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            $user->tokens()->delete(); // For Laravel Sanctum
            // $request->user()->token()->revoke(); // For Laravel Passport

            return message([], 'Successfully logged out', 200);
        }
        return message([], 'Unauthorized', 401);
    }
}
