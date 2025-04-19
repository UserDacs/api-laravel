<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'rating' => 'required|integer|min:1|max:5'
        ]);

        // Check if user already rated the service
        $existingRating = Rating::where('service_id', $request->service_id)
                                ->where('user_id', Auth::id())
                                ->first();

        if ($existingRating) {
            return response()->json([
                'message' => 'You have already rated this service.'
            ], 409);
        }

        $rating = Rating::create([
            'service_id' => $request->service_id,
            'user_id' => Auth::id(),
            'rating' => $request->rating
        ]);

        return response()->json([
            'message' => 'Rating added successfully.',
            'data' => $rating
        ], 201);
    }

    public function index() {
        $ratings = DB::table('unified_ratings_view')->get();
		return view('admin.ratings',compact('ratings'));
	}


    public function rateService(Request $request)
    {
        DB::statement("CALL rate_service(?, ?, ?)", [
            $request->service_id,
            $request->user_id,
            $request->rating
        ]);

        return response()->json(['message' => 'Service rated successfully']);
    }

    public function rateShop(Request $request)
    {
        DB::statement("CALL rate_shop(?, ?, ?)", [
            $request->shop_id,
            $request->user_id,
            $request->rating
        ]);

        return response()->json(['message' => 'Shop rated successfully']);
    }

    public function rateTechnician(Request $request)
    {
        DB::statement("CALL rate_technician(?, ?, ?)", [
            $request->technician_id,
            $request->user_id,
            $request->rating
        ]);

        return response()->json(['message' => 'Technician rated successfully']);
    }

    public function addServiceComment(Request $request)
    {
        DB::statement("CALL add_service_comment(?, ?, ?)", [
            $request->service_id,
            $request->user_id,
            $request->comment
        ]);

        return response()->json(['message' => 'Comment added successfully']);
    }

    public function replyToServiceComment(Request $request)
    {
        try {
            // Call the stored procedure
            DB::statement("CALL reply_to_service_comment(?, ?, ?)", [
                $request->comment_id,
                $request->user_id,
                $request->reply
            ]);

            // Get the latest reply
            $data = DB::table('service_comment_replies_view')
                ->where('comment_id', $request->comment_id)
                ->orderBy('created_at', 'desc')
                ->first();

            // Format time if data is found
            if ($data) {
                $data->created_at = humanReadableTime($data->created_at);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Reply added successfully',
                'data' => $data
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong',
                'error' => $e->getMessage() // optional, remove in production if needed
            ]);
        }
    }
}
