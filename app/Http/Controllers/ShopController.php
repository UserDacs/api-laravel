<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use Illuminate\Support\Facades\DB;

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

}
