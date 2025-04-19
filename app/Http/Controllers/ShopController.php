<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ShopController extends Controller
{
    //
	public function index() {
        $shops = DB::table('view_users_with_shops')->where('role','provider')->get();
		return view('admin.shops',compact('shops'));
	}

    public function create()
    {
        return view('admin.shops.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'shop_name'  => 'required',
            'shop_address'  => 'required',
            'shop_details'  => 'required',
            'shop_lat'  => 'required',
            'shop_long'  => 'required',
        ]);


        Shop::create($validated);

        return redirect()->route('admin.shops')->with('success', 'Shop created successfully.');
    }


    public function edit($id)
    {
        $shop = Shop::find($id);
        return view('admin.shops.edit', compact('shop'));
    }

    // Update existing user
    public function update(Request $request, $id)
    {
        $user = Shop::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'required',
            'shop_name'  => 'required',
            'shop_address'  => 'required',
            'shop_details'  => 'required',
            'shop_lat'  => 'required',
            'shop_long'  => 'required',
        ]);

        $user->update($validated);

        return redirect()->route('admin.shops')->with('success', 'Shop updated successfully.');
    }

    public function apiShopList() {
        $services = DB::table('shop_with_services_json')->get();

        foreach ($services as $service) {
            $service->services = json_decode($service->services); // ← ito ang tamang function
        }

        return response()->json($services);
    }

    // profile_images

    public function updateShop(Request $request)
    {


        // Validate request (optional pero recommended)

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'shop_name' => 'required|string|max:255',
            'shop_address' => 'required|string|max:255',
            'shop_details' => 'nullable|string',
            'shop_lat' => 'nullable|numeric',
            'shop_long' => 'nullable|numeric',
            'shop_image' => 'nullable|image|mimes:jpg,jpeg,png',
            'national_id' => 'nullable|image|mimes:jpg,jpeg,png',
            'cor' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        // Save image files to storage
        $shopImagePath = "/storage/".$request->file('shop_image')?->store('profile_images', 'public');
        $nationalIdPath = "/storage/".$request->file('national_id')?->store('profile_images', 'public');
        $corPath = "/storage/".$request->file('cor')?->store('profile_images', 'public');

        Log::info($request->all());
        Log::info($request->files->all());

        // Insert into shops table
        DB::table('shops')->insert([
            'user_id' => $request->input('user_id'),
            'shop_name' => $request->input('shop_name'),
            'shop_address' => $request->input('shop_address'),
            'shop_details' => $request->input('shop_details'),
            'shop_lat' => $request->input('shop_lat'),
            'shop_long' => $request->input('shop_long'),
            'status' => 'pending', // default
            'shop_image' => $shopImagePath,
            'shop_national_id' => $nationalIdPath,
            'cor' => $corPath,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user = User::find($request->input('user_id'));

        return response()->json(['message' => 'Shop created successfully.'], 200);
    }

    public function apiShopuser() {
        $user_id = $_GET['user_id'] ?? null;
        if ($user_id) {
            $services = DB::table('shops')->where('user_id','=',$user_id)->where('status','=','pending')->get();
        }

        return response()->json($services);
    }


}
