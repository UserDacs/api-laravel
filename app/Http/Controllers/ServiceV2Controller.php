<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ServiceV2;
use Illuminate\Support\Facades\Log;

class ServiceV2Controller extends Controller
{
    //
	public function index() {
        // $shops = DB::table('full_service_view')->where('shop_owner_user_status','active')->get();
        $services = DB::table('full_service_view')->get();
		return view('admin.service_v2',compact('services'));
	}

    public function create()
    {
        return view('admin.service_v2.create');
    }

    public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'shop_id' => 'required',
            'technician_id'  => 'required',
            'category_id'  => 'required',
            'service_name'  => 'required',
            'price'  => 'required',
            'description'  => 'required',
            // 'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $path = $image->store('profile_images', 'public');
            $validated['image_path'] = '/storage/' . $path;
        }else{
            $validated['image_path'] = "/images/no-image-1.png";
        }

        // Kunin muna ang technician
        $technician = DB::table('technicians')->where('id', $validated["technician_id"])->first();

        // if ($technician) {
        //     if ($technician->shop_id == 0) {
        //         DB::table('technicians')
        //             ->where('id', $validated["technician_id"])
        //             ->update([
        //                 'shop_id' => $validated["shop_id"],
        //                 'updated_at' => now(),
        //             ]);
        //     } else {
        //         Log::info('Technician is already assigned to a shop.');
        //         return redirect()->back()->with('error', 'Technician is already assigned to a shop.');
        //     }
        // } else {
        //     Log::info('Technician not found.');
        //     return redirect()->back()->with('error', 'Technician not found.');
        // }

        if (!$technician) {
            Log::info('Technician not found.');
            return redirect()->back()->with('error', 'Technician not found.');
        }

        $sa = ServiceV2::create($validated);
        Log::info($sa);

        return redirect()->route('admin.services')->with('success', 'Services created successfully.');
    } catch (\Exception $e) {
        // Log the error
        Log::error('Error in Service Store: ' . $e->getMessage(), [
            'stack' => $e->getTraceAsString(),
            'input' => $request->all(),
        ]);

        return redirect()->back()->with('error', 'Something went wrong. Please try again.');
    }
}


    public function edit($id)
    {
        $service = ServiceV2::find($id);
        return view('admin.service_v2.edit', compact('service'));
    }

    // Update existing user
    public function update(Request $request, $id)
    {
        $service = ServiceV2::findOrFail($id);

        $validated = $request->validate([
            'shop_id' => 'required',
            'technician_id'  => 'required',
            'category_id'  => 'required',
            'service_name'  => 'required',
            'price'  => 'required',
            'description'  => 'required',
            // 'image_path'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $path = $image->store('profile_images', 'public');
            $validated['image_path'] = '/storage/' . $path;
        }else{
            $validated['image_path'] = "/images/no-image-1.png";
        }

        // Kunin ang technician record
        $technician = DB::table('technicians')->where('id', $validated["technician_id"])->first();

        if ($technician) {
            if ($technician->shop_id == 0) {
                // Kung hindi pa assigned, i-update ang shop_id
                DB::table('technicians')
                    ->where('id', $validated["technician_id"])
                    ->update([
                        'shop_id' => $validated["shop_id"],
                        'updated_at' => now(),
                    ]);
            } elseif ($technician->shop_id != $validated["shop_id"]) {
                // Kung naka-assign na sa ibang shop, huwag payagan
                return redirect()->back()->with('error', 'Technician is already assigned to a different shop.');
            }
        } else {
            return redirect()->back()->with('error', 'Technician not found.');
        }

        // I-update ang service
        $service->update($validated);

        return redirect()->route('admin.services')->with('success', 'Services updated successfully.');
    }

    public function getServiceApi(Request $request)
    {
        $services = DB::table('full_service_view');



        // Apply filters if 'recomended' parameter is set to "1"
        if ($request->input('recomended') === "1") {
            $services = $services
                ->whereNotNull('average_rating')
                ->whereNotNull('total_reviews')
                ->orderByDesc('average_rating');
        } else {
            // Optional: You can also apply a default ordering if needed
            $services = $services->orderBy('average_rating', 'desc');
        }

        if ($request->filled('serviceId')) {
            $services =  $services->where('service_id', $request->input('serviceId'));
        }

        // Execute the query
        $services = $services->get();

        // Return JSON response
        return response()->json([
            'status' => 200,
            'recomended' => $request->input('recomended'),
            'serviceId' => $request->input('serviceId'),
            'message' => "Fetch successfully.",
            'data' => $services
        ]);
    }

    public function apiServiceList() {
        $serviceId = $_GET['service_id'] ?? null;
        if ($serviceId) {
            $services = DB::table('full_service_view')->where('service_id','=',$serviceId)->get();
        } else {
            $services = DB::table('full_service_view')->get();
        }

        return response()->json($services);
    }

    public function apiRatingList() {
        $serviceId = $_GET['service_id'] ?? null;
        if ($serviceId) {
            $services = DB::table('view_service_feedback')->where('service_id','=',$serviceId)->get();
        } else {
            $services = DB::table('view_service_feedback')->get();
        }

        return response()->json($services);
    }

}
