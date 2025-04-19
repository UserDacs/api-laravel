<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    //
	public function index() {

        $categories = Category::all();
		return view('admin.category',compact('categories'));
	}

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:255',
            'description'  => 'required',
        ]);


        Category::create($validated);

        return redirect()->route('admin.category')->with('success', 'Category created successfully.');
    }


    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    // Update existing user
    public function update(Request $request, $id)
    {
        $user = Category::findOrFail($id);

        $validated = $request->validate([
           'category_name' => 'required|string|max:255',
           'description'  => 'required',
        ]);

        $user->update($validated);

        return redirect()->route('admin.category')->with('success', 'Category updated successfully.');
    }


    public function apiCategoryList() {
        $services = DB::table('categories')->get();
        return response()->json($services);
    }

}
