<?php
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\ServiceV2;
use App\Models\Category;
use App\Models\BookingV2;


if (!function_exists('validate_password')) {
    function validate_password(string $password): bool
    {
        return preg_match('/^(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{6,}$/', $password);
    }
}

if (!function_exists('message')) {

    function message($data = [], $message = 'Success', $status = 200)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ]);
    }
}

if (!function_exists('get_user_with_shop')) {

    function get_user_with_shop()
    {
        return DB::table('view_users_with_shops')->get();
    }
}


if (!function_exists('get_user_no_shop')) {

    function get_user_no_shop()
    {
        return DB::table('view_users_without_shops')->where('role','provider')->get();
    }
}


if (!function_exists('get_users_not_technicians')) {

    function get_users_not_technicians()
    {
        return DB::table('view_technicians')->get();
    }
}


if (!function_exists('get_category')) {

    function get_category()
    {
        return DB::table('categories')->get();
    }
}



if (!function_exists('get_service_comment_replies_view')) {

    function get_service_comment_replies_view()
    {
        return DB::table('service_comment_replies_view')->get();
    }
}

if (!function_exists('get_service_comment_populate')) {

    function get_service_comment_populate($id)
    {
        return DB::table('service_comments_view')->where('service_id',$id)->get();
    }
}


if (!function_exists('get_service_comment_reply_populate')) {

    function get_service_comment_reply_populate($id)
    {
        return DB::table('service_comment_replies_view')->where('comment_id',$id)->get();
    }
}

if (!function_exists('humanReadableTime')) {
    function humanReadableTime($datetime)
    {
        // Get the current time in Manila timezone
        $now = new DateTime('now', new DateTimeZone('Asia/Manila'));

        // Create a DateTime object for the input datetime
        $created_at = new DateTime($datetime, new DateTimeZone('Asia/Manila'));

        // Calculate the difference in seconds
        $diff = $now->getTimestamp() - $created_at->getTimestamp();

        // Calculate the difference in human-readable format
        if ($diff < 60) {
            if ($diff == 0) {
                return'Now';
            }
            return $diff . ' sec';
        } elseif ($diff < 3600) {
            return floor($diff / 60) . ' min';
        } elseif ($diff < 86400) {
            // Calculate hours and minutes for less than 24 hours difference
            $hours = floor($diff / 3600);
            $minutes = floor(($diff % 3600) / 60);

            // Return the difference in hours and minutes format
            if ($hours == 1) {
                return "1 h" . ($minutes ? " $minutes min" : "") . "";
            } else {
                return "$hours h" . ($minutes ? " $minutes min" : "") . "";
            }
        } elseif ($diff < 2592000) {
            return floor($diff / 86400) . ' days';
        } elseif ($diff < 31536000) {
            return floor($diff / 2592000) . ' months';
        } else {
            return floor($diff / 31536000) . ' years';
        }
    }
}


if (!function_exists('formated_time')) {

    function formated_time($datetime)
    {
        // Create a DateTime object in the Manila timezone
        $created_at = new DateTime($datetime, new DateTimeZone('Asia/Manila'));

        // Format the date as "m/d/Y h:ia" (e.g., 4/15/2025 09:02AM)
        return $created_at->format('n/j/Y h:ia');
    }
}


if (!function_exists('total_technician')) {

    function total_technician()
    {
        return User::where('role','technician')->count();
    }
}

if (!function_exists('total_services')) {

    function total_services()
    {
        return ServiceV2::count();
    }
}

if (!function_exists('total_category')) {

    function total_category()
    {
        return Category::count();
    }
}

if (!function_exists('total_users')) {

    function total_users()
    {
        return User::count();
    }
}

if (!function_exists('total_bookings')) {

    function total_bookings()
    {
        return BookingV2::count();
    }
}




