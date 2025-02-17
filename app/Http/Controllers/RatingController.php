<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
