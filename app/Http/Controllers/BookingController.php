<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    // Store Booking
    public function store(Request $request) {
        $validated = $request->validate([
            'tracking_number' => 'required|unique:bookings',
            'booking_date' => 'required|date',
            'booking_details' => 'nullable|string',
            'booking_location' => 'required|string',
            'payment_method' => 'required|in:cash,card,online',
            'total_price' => 'required|numeric',
            'service_id' => 'required|exists:services,id',
            'user_id' => 'required|exists:users,id',
            'owner_id' => 'required|exists:users,id'
        ]);

        $booking = Booking::create($validated);

        return response()->json([
            'message' => 'Booking created successfully',
            'data' => $booking
        ], 201);
    }

    // Get All Bookings
    public function index() {
        $bookings = Booking::with(['service', 'user', 'owner', 'cancel'])->get();
        return response()->json($bookings);
    }

    // Get Single Booking
    public function show(Request $request) {
        $booking = Booking::with(['service', 'user', 'owner', 'cancel'])->findOrFail($request->input('booking_id'));
        return response()->json($booking);
    }


    public function cancel(Request $request) {
        $booking = Booking::findOrFail($request->input('booking_id'));
    
        if ($booking->status === 'cancel') {
            return response()->json(['message' => 'Booking is already canceled'], 400);
        }
    
        $booking->status = 'cancel';
        $booking->save();
    
        $cancel = $booking->cancel()->create([
            'reason' => $request->input('reason')
        ]);
    
        return response()->json([
            'message' => 'Booking canceled successfully',
            'cancel' => $cancel
        ]);
    }
}
