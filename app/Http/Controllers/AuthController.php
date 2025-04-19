<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }



    public function register(Request $request)
    {
        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname'  => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|string|min:6|confirmed',
            'role'      => 'required|string',
            'phone'     => 'nullable|string',
            // 'status'    => ['required', Rule::in(['active', 'inactive'])],
            'image_path'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $path = $image->store('profile_images', 'public');
            $validated['image_path'] = '/storage/' . $path;
        }else {
            $validated['image_path'] = "/images/no-image-1.png";
        }



        $user = $this->authService->register($validated);

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

    public function mobileAuth(Request $request)
    {
        $validatedData = $request->validate([

            'user_id' => 'required',
            'mobile_auth' => 'required',

        ]);

        return $this->authService->mobileAuth($validatedData);
    }

    // Admin Functions


    public function showLogin() {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }


    public function adminLogin(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'errors' => [
                    'email' => ['This email is not registered.'],
                ],
            ], 422);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'errors' => [
                    'password' => ['Incorrect password.'],
                ],
            ], 422);
        }

        Auth::login($user);
        $request->session()->regenerate();

        return response()->json([
            'status' => 'success',
            'message' => 'Login successful.',
            'redirect' => route('admin.dashboard')
        ]);
    }

    public function adminLogout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

}
