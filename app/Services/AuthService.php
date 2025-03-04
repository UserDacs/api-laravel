<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AuthService
{
    public function register(array $data)
    {


        if (!validate_password($data['password'])) {
            return message([], 'Password must be 6 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character', 422);
        }

        if (User::where('email', $data['email'])->exists()) {
            return message([], 'Email already exists', 409);
        }
        $user_id = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role'=> $data['role']
        ]);

        $user_data = User::find($user_id->id);

        if (!$user_data) {
            return message([], 'Error! please contact administrator', 409);
        }

        return $this->generateToken($user_data);
    }

    public function login(array $data)
    {
        $user = User::where('email', $data['email'])->first();
        if (!$user) {
            return message([], 'Email not found', 404);
        }

        if (!Hash::check($data['password'], $user->password)) {
            return message([], 'Incorrect password', 404);
        }

        return $this->generateToken($user);
    }

    private function generateToken(User $user): JsonResponse
    {
        $token = $user->createToken('auth_token')->plainTextToken;

        $data = [
            'token' => $token,
            'user' => $user
        ];
        return message($data, 'Login successful', 200);
    }

    public function mobileAuth(array $data)
    {
        
        $user = User::find($data['user_id']);

        if (!$user) {
            return message([], 'Error! Please contact the administrator.', 409);
        }

        if ($data['mobile_auth'] === 'authenticated') {
            return $this->generateToken($user);
        }

        return message([], 'Not authenticated', 409);
    }
}
