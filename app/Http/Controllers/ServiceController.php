<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Http\Resources\ServiceResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'service_fee' => 'required|numeric|min:0',
            'photo_path' => 'nullable|string',
            'is_public' => 'required|boolean',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $service = Service::create($request->all());

        return response()->json([
            'statu'=> 200,
            'message' => "Save successfully.",
            'data' => new ServiceResource($service)
        ]);
    }

    public function update(Request $request, $id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'service_fee' => 'required|numeric|min:0',
            'photo_path' => 'nullable|string',
            'is_public' => 'required|boolean',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $service->update($request->all());

        return response()->json([
            'statu'=> 200,
            'message' => "Update successfully.",
            'data' => new ServiceResource($service)
        ]);
    }


    public function populate(Request $request)
    {
        $services = DB::table('view_user_services')->get();

        // Group data by service_id to format comments as nested
        $formattedServices = [];
        foreach ($services as $service) {
            $service_id = $service->service_id;

            // Initialize service data
            if (!isset($formattedServices[$service_id])) {
                $formattedServices[$service_id] = [
                    'service_id' => $service->service_id,
                    'service_name' => $service->service_name,
                    'description' => $service->service_description,
                    'service_fee' => $service->service_fee,
                    'service_photo' => $service->service_photo,
                    'service_rating' => $service->service_rating,
                    'comments' => [],
                ];
            }

            // Process comments & replies
            if ($service->comment_id) {
                $formattedServices[$service_id]['comments'][] = [
                    'comment_id' => $service->comment_id,
                    'parent_id' => $service->comment_parent_id,
                    'user_id' => $service->comment_user_id,
                    'comment_text' => $service->comment_text,
                    'created_at' => $service->comment_created_at,
                    'updated_at' => $service->comment_updated_at,
                ];
            }
        }

        return response()->json([
            'status' => 200,
            'message' => "Data retrieved successfully.",
            'data' => array_values($formattedServices) // Re-index array
        ]);
    }

    public function view_user_services_provider(Request $request)
    {

        $services = DB::table('view_user_services_provider')
                ->where('user_id', $request->input('user_id'))
                ->get();

        return response()->json([
            'statu'=> 200,
            'message' =>"Display successfully to provider.",
            'data' => $services
        ]);
    }

    public function show(Request $request)
    {
        $serviceId = $request->input('service_id');

        if (!$serviceId) {
            return response()->json(['message' => 'Service ID is required'], 400);
        }

        $service = Service::with(['comments', 'ratings'])->find($serviceId);

        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        $averageRating = $service->ratings()->avg('rating');

        return response()->json([
            'service' => $service,
            'averageRating' => round($averageRating, 1)
        ]);
    }


    public function listWithCommentsAndRatings(Request $request)
    {
        $services = Service::with([
            'user',               // Includes the user who owns the service
            'comments.user',      // Includes the user who made the comments
            'comments.ratings',   // Includes ratings per comment
            'ratings'             // Includes overall service ratings
        ])
        ->orderBy('created_at', 'desc') // Sort by newest first
        ->get();

        return response()->json($services);
    }

    public function listWithCommentsAndRatingsProvider(Request $request)
    {
        $services = Service::with([
            'comments.user', // Include user info for each comment
            'comments.ratings', // Include ratings per comment
            'ratings'
        ])->where('services.user_id',$request->input('user_id'))->get();

        return response()->json($services);
    }

    public function getServiceWithComments($id)
    {
        $service = Service::with(['user', 'comments.replies.user', 'ratings'])
                    ->withCount('ratings')
                    ->findOrFail($id);

        $averageRating = $service->averageRating();

        return response()->json([
            'service' => $service,
            'average_rating' => $averageRating
        ]);
    }

	public function index() {
		return view('admin.services');
	}
}
