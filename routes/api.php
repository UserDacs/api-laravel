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

});