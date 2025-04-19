<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AuthService
{
    public function register(array $data)
    {
        // Password complexity validation
        if (!validate_password($data['password'])) {
            return message([], 'Password must be at least 6 characters and include one uppercase, one lowercase, one number, and one special character.', 422);
        }

        // Check if email already exists
        if (User::where('email', $data['email'])->exists()) {
            return message([], 'Email already exists', 409);
        }

        // Combine full name
        $data['name'] = $data['firstname'] . ' ' . $data['lastname'];
        $data['password'] = Hash::make($data['password']);

        // Create user
        $user = User::create([
            'name'      => $data['name'],
            'firstname' => $data['firstname'],
            'lastname'  => $data['lastname'],
            'email'     => $data['email'],
            'phone'     => $data['phone'],
            'password'  => $data['password'],
            'image_path'  => $data['image_path'],
            'role'      => $data['role'],
        ]);

        // Get user data
        $user_data = User::find($user->id);

        // if ($data['role'] == 'technician') {
        //     DB::table('technicians')->insert([
        //         'user_id' => $user->id,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]);
        // }

        if (!$user_data) {
            return message([], 'Error! Please contact administrator.', 409);
        }

        // Return user with token
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
