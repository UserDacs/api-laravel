<?php

use Illuminate\Validation\ValidationException;

if (!function_exists('validate_password')) {
    function validate_password(string $password): bool
    {
        return preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,10}$/', $password);
    }
}

if (!function_exists('message')) {

    function message($data = [], $message = 'Success', $status = 200)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $status);
    }
}