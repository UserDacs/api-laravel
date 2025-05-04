<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\MessageController;
use App\Http\Controllers\ServiceV2Controller;

use App\Http\Controllers\ShopController;
use App\Http\Controllers\NotificationController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Authorization');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/mobile-auth', [AuthController::class, 'mobileAuth']);

Route::post('/register3', [UserController::class, 'register3']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);


    Route::post('/services', [ServiceController::class, 'store']);
    Route::post('/services/update/{id}', [ServiceController::class, 'update']);
    Route::post('/services/data', [ServiceController::class, 'populate']);
    Route::post('/services/provider', [ServiceController::class, 'view_user_services_provider']);

    Route::post('/services/show', [ServiceController::class, 'show']);

    Route::post('/services/list-with-comments', [ServiceController::class, 'listWithCommentsAndRatings']);


    Route::post('/services/list-with-comments-provider', [ServiceController::class, 'listWithCommentsAndRatingsProvider']);




    Route::post('/services/comment', [CommentController::class, 'store']);
    Route::post('/services/rate', [RatingController::class, 'store']);

    Route::post('/services/{id}/comments', [ServiceController::class, 'getServiceWithComments']);


    Route::post('/bookings', [BookingController::class, 'store']);
    Route::post('/bookings-all', [BookingController::class, 'index']);
    Route::post('/bookings-show', [BookingController::class, 'show']);


    Route::post('/bookings/cancel', [BookingController::class, 'cancel']);


    Route::post('/update-profile', [UserController::class, 'updateProfile']);

    Route::post('/update-account', [UserController::class, 'apiUpdatePrifile']);



    Route::post('/get-service-list', [ServiceV2Controller::class, 'getServiceApi']);

    Route::post('/v2/message/send', [MessageController::class, 'send']);
    Route::get('/v2/message/inbox', [MessageController::class, 'inbox']);
    Route::get('/v2/message/conversation/{userId}', [MessageController::class, 'conversation']);
    Route::patch('/v2/message/read/{id}', [MessageController::class, 'markAsRead']);
    Route::get('/v2/message/constac', [MessageController::class, 'constac']);





    Route::get('/v2/service-list', [App\Http\Controllers\ServiceV2Controller::class, 'apiServiceList']);
    Route::get('/v2/category-list', [App\Http\Controllers\CategoryController::class, 'apiCategoryList']);
    Route::get('/v2/comment-list', [App\Http\Controllers\ServiceV2Controller::class, 'apiRatingList']);

    Route::post('/v2/bookings', [BookingController::class, 'storeApi']);

    Route::get('/v2/bookings-show', [BookingController::class, 'apiBookingList']);

    Route::post('/v2/change-password', [App\Http\Controllers\UserController::class, 'changePassword']);

    Route::get('/v2/shop-list', [ShopController::class, 'apiShopList']);

    Route::post('/v2/shop-create', [ShopController::class, 'updateShop']);

    Route::get('/v2/shop-check', [ShopController::class, 'apiShopuser']);



    // apiShopList
    // storeApi updateImage

    // Route::post('/update-profile', [UserController::class, 'updateProfile']);

});

Route::middleware('auth:sanctum')->group(function () {
    // Get all notifications for the authenticated user
    Route::get('/notifications', [NotificationController::class, 'index']);
    
    // Get unread notification counts by category for the authenticated user

    
    // Mark a notification as read
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    
    // Send a custom notification (could be used for testing or admin usage)
    Route::post('/notifications/send', [NotificationController::class, 'sendNotification']);
});

Route::get('/notifications/counts', [NotificationController::class, 'counts']);

Route::get('/notifications/list', [NotificationController::class, 'list']);


Route::post('/notifications/mark-as-read', function (Request $request) {
    $notif = \DB::table('notifications')->where('id', $request->id)->first();

    if ($notif && is_null($notif->read_at)) {
        \DB::table('notifications')->where('id', $request->id)->update([
            'read_at' => now()
        ]);
    }

    return response()->json(['success' => true]);
});
