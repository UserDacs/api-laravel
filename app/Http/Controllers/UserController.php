<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\LOG;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use App\Models\Notification;

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

    public function index_admin() {
        $users = User::where('role','admin')->get();
		return view('admin.users_admin',compact('users'));
	}

    public function index_shop_owner() {
        $users = User::where('role','provider')->get();
		return view('admin.users_shop_owner',compact('users'));
	}
    public function index_technician() {
        $users = User::where('role','technician')->get();
		return view('admin.users_technician',compact('users'));

	}
    public function index_customer() {
        $users = User::where('role','customer')->get();
		return view('admin.users_customer',compact('users'));
	}

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname'  => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|string|min:6|confirmed',
            'role'      => 'required|string',
            'status'    => ['required', Rule::in(['active', 'inactive'])],
            'phone'             => 'nullable|string',
            'address_street'    => 'nullable|string',
            'address_city'      => 'nullable|string',
            'address_state'     => 'nullable|string',
            'address_zip_code'  => 'nullable|string',
            'mobile_auth'       => 'nullable|string',
            'image_path'        => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Handle image upload Admin1234!
        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $path = $image->store('profile_images', 'public'); // Save under storage/app/public/users
            $validated['image_path'] = '/storage/' . $path;
        }

        $validated['name'] = $validated['firstname'] . ' ' . $validated['lastname'];
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users')->with('success', 'User created successfully.');
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // Update existing user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname'  => 'required|string|max:255',
            'email'     => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password'  => 'nullable|string|min:6|confirmed',
            'role'      => 'required|string',
            'status'    => ['required', Rule::in(['active', 'inactive'])],
            'phone'             => 'nullable|string',
            'address_street'    => 'nullable|string',
            'address_city'      => 'nullable|string',
            'address_state'     => 'nullable|string',
            'address_zip_code'  => 'nullable|string',
            'mobile_auth'       => 'nullable|string',
            'image_path'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

         // Handle image upload
        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $path = $image->store('profile_images', 'public'); // Save under storage/app/public/users
            $validated['image_path'] = '/storage/' . $path;
        }


        $validated['name'] = $validated['firstname'] .' '.$validated['lastname'];

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    }

    // Deactivate / Activate user
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();

        return redirect()->route('admin.users')->with('success', 'User status updated.');
    }

    public function searchUsers(Request $request)
    {
        $keyword = $request->query('q');

        if (!$keyword) {
            return response()->json([]);
        }

        $users = User::where('name', 'like', "%$keyword%")
            ->orWhere('email', 'like', "%$keyword%")
            ->limit(10)
            ->get(['id', 'name', 'email', 'image_path']);

        return response()->json($users);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|min:6',
            'confirm_new_password' => 'required|same:new_password',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'message' => 'Old password is incorrect.',
                'errors' => ['old_password' => ['Old password is incorrect.']]
            ], 422);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password updated successfully.']);
    }

    public function updateField(Request $request)
    {
        // Validate input
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string',
        ]);

        $user = Auth::user();

        // Update the specified field dynamically
        switch ($request->field) {
            case 'firstname':
                $user->firstname = $request->value;
                break;
            case 'lastname':
                $user->lastname = $request->value;
                break;
            case 'email':
                $user->email = $request->value;
                break;
            case 'phone':
                $user->phone = $request->value;
                break;
            case 'street':
                $user->address_street = $request->value;
                break;
            case 'city':
                $user->address_city = $request->value;
                break;
            case 'state':
                $user->address_state = $request->value;
                break;
            case 'zipcode':
                $user->address_zip_code = $request->value;
                break;
            default:
                return response()->json(['error' => 'Invalid field'], 422);
        }

        // Save updated user data
        $user->save();

        return response()->json(['message' => 'Field updated successfully.']);
    }

    public function register3(Request $request)
    {
        $validated = $request->validate([
            'firstname'         => 'required|string|max:255',
            'lastname'          => 'required|string|max:255',
            'email'             => 'required|email|unique:users,email',
            'password'          => 'required|string|min:6|confirmed',
            'role'              => 'required|string',
            'status'            => ['required', Rule::in(['active', 'inactive'])],
            'phone'             => 'nullable|string',
            'address_street'    => 'nullable|string',
            'address_city'      => 'nullable|string',
            'address_state'     => 'nullable|string',
            'address_zip_code'  => 'nullable|string',
            'mobile_auth'       => 'nullable|string',
            'image_path'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $path = $image->store('profile_images', 'public');
            $validated['image_path'] = '/storage/' . $path;
        }

        $validated['name'] = $validated['firstname'] . ' ' . $validated['lastname'];
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return response()->json([
            'message' => 'User registered successfully.'
        ], 201);
    }

    public function updateImage(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'image_path' => 'nullable|file|mimes:jpeg,jpg,png|max:2048',
        ]);

        $user = User::findOrFail($request->user_id);

        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $path = $image->store('profile_images', 'public');
            $user->image_path = '/storage/' . $path;
        }

        $user->save();

        return response()->json($user);
    }


    public function apiUpdatePrifile(Request $request)
    {
        $user_id = $request->input('user_id');
        $user = User::findOrFail($user_id);

        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname'  => 'required|string|max:255',
            'email'     => 'required',
            'phone'             => 'nullable|string',
            'address_street'    => 'nullable|string',
            'address_city'      => 'nullable|string',
            'address_state'     => 'nullable|string',
            'address_zip_code'  => 'nullable|string',
        ]);


        $validated['name'] = $validated['firstname'] .' '.$validated['lastname'];

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return response()->json($user);
    }


    public function notifyUser(Request $request)
    {
        // $request->validate([
        //     'userId' => 'required|integer',
        //     'message' => 'required|string',
        //     'title' => 'nullable|string',
        //     'type' => 'nullable|string',
        //     'url' => 'nullable|url',
        //     'image_path' => 'nullable|string',
        // ]);
    
        $userId = $request->input('userId');
        $message = $request->input('message');
        $title = $request->input('title') ?? 'Notification';
        $type = $request->input('type') ?? 'message';
        $url = $request->input('url');
        $imagePath = $request->input('image_path');
    
        // Save to DB
        $notification = Notification::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'status' => 'unread',
            'url' => $url,
            'image_path' => $imagePath,
        ]);
    
        // Send to Node.js
        $response = Http::post('http://192.168.1.100:3000/notify', [
            'userId' => $userId,
            'message' => $message,
            'title' => $title,
            'url' => $url,
            'image_path' => $imagePath,
            'type' => $type,
        ]);
    
        return response()->json([
            'success' => true,
            'status' => $response->json(),
        ]);
    }
}
