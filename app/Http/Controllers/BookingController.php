<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Notifications\GeneralNotification;
use App\Models\User;
use Illuminate\Support\Facades\Validator;



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
	public function index2() {

        $bookings = DB::table('booking_details_v2')->get();
		return view('admin.bookings',compact('bookings'));
	}


    public function storeApi(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:service_v2_s,id',
            'customer_id' => 'required|exists:users,id',
            'booking_date' => 'nullable|date',
            'booking_address' => 'required|string|max:255',
            'booking_duration' => 'nullable|string|max:255',
            'booking_lat' => 'nullable|numeric',
            'booking_long' => 'nullable|numeric',
            'booking_status' => 'required|in:pending,cancel,done',
            'payment_method' => 'required|in:cash,card,online',
        ]);

        // ✅ Check kung meron nang pending booking with same service_id & customer_id
        $existingBooking = DB::table('booking_v2_s')
            ->where('service_id', $validated['service_id'])
            ->where('customer_id', $validated['customer_id'])
            ->where('booking_status', 'pending')
            ->first();

        if ($existingBooking) {
            return response()->json([
                'message' => 'You already have a pending booking for this service.'
            ], 409); // Conflict
        }

        $usr_id = DB::table('view_booking_user_id')
            ->where('service_id', $validated['service_id'])
            ->first();

        $user = User::find($usr_id->user_id);

        // Send the notification to the user
        $user->notify(new GeneralNotification(
            "New Booking",
            'Booking',
            "booking"
        ));

        // ✅ Proceed with insert
        DB::table('booking_v2_s')->insert([
            'service_id'       => $validated['service_id'],
            'customer_id'      => $validated['customer_id'],
            'booking_date'     => $validated['booking_date'],
            'booking_address'  => $validated['booking_address'],
            'booking_duration' => $validated['booking_duration'],
            'booking_lat'      => $validated['booking_lat'],
            'booking_long'     => $validated['booking_long'],
            'booking_status'   => $validated['booking_status'],
            'payment_method'   => $validated['payment_method'],
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        return response()->json(['message' => 'Booking inserted successfully.']);
    }

    public function apiBookingList() {
        $customer_id = $_GET['customer_id'] ?? null;

        Log::info($customer_id);

        $user = User::find($customer_id);

        Log::info($user);
        // shop_user_id

        $services = [];
      
        if ($user) {
           if ($user->role === 'provider') {
             $services = DB::table('booking_details_v2')->where('shop_user_id','=',$user->id)->get();
           }else{
             $services = DB::table('booking_details_v2')->where('customer_id','=',$user->id)->get();
           }
        }

        // if ($customer_id) {
        //     $services = DB::table('booking_details_v2')->where('customer_id','=',$customer_id)->get();
        // } else {
        //     $services = DB::table('booking_details_v2')->get();
        // }

        return response()->json($services);
    }

    public function updateStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:booking_v2_s,id',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::table('booking_v2_s')
            ->where('id', $request->id)
            ->update([
                'booking_status' => $request->status,
                'updated_at' => now()
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking status updated successfully.'
        ]);
    }
}
