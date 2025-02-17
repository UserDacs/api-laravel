<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\LOG;
use App\Models\User;


class UserController extends Controller
{
    public function updateProfile(Request $request)
    {
        LOG::info($request->all());
        $request->validate([
            'user_id' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user = User::where('id',$request->user_id)->first();

        // Handle Image Upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('profile_images', 'public');
            $user->image_path = '/storage/' . $path;
        }

        $user->save();

        return response()->json([
            'status'  => 200,
            'message' => 'Profile updated successfully',
            'user'    => $user
        ]);
    }

}
