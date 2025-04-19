<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\MessageController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('admin.dashboard');
    }else{
        return redirect()->route('admin.login');
    }
});


Route::get('/admin-login', [App\Http\Controllers\AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin-login', [App\Http\Controllers\AuthController::class, 'adminLogin'])->name('admin.login');

Route::get('/admin-logout', [App\Http\Controllers\AuthController::class, 'adminLogout'])->name('logout');
// Admin
Route::middleware(['admin'])->group(function () {
    Route::get('/admin-dashboard', [App\Http\Controllers\DashboardController::class, 'admin'])->name('admin.dashboard');
    // newfile
	Route::get('/admin-services', [App\Http\Controllers\ServiceV2Controller::class, 'index'])->name('admin.services');
	Route::get('/admin-customer_service', [App\Http\Controllers\CustomerServiceController::class, 'index'])->name('admin.customer_service');
	Route::get('/admin-category', [App\Http\Controllers\CategoryController::class, 'index'])->name('admin.category');
	Route::get('/admin-bookings', [App\Http\Controllers\BookingController::class, 'index2'])->name('admin.bookings');
	Route::get('/admin-service_v2', [App\Http\Controllers\ServiceController::class, 'index'])->name('admin.service_v2');
	Route::get('/admin-shops', [App\Http\Controllers\ShopController::class, 'index'])->name('admin.shops');
    Route::get('/admin-users', [App\Http\Controllers\UserController::class, 'index_admin'])->name('admin.users');
    Route::get('/admin-users-shops-owner', [App\Http\Controllers\UserController::class, 'index_shop_owner'])->name('admin.shop_owner');
    Route::get('/admin-users-technician', [App\Http\Controllers\UserController::class, 'index_technician'])->name('admin.users_technician');
    Route::get('/admin-users-customer', [App\Http\Controllers\UserController::class, 'index_customer'])->name('admin.users_customer');


    // create users
    Route::get('/admin-create', [App\Http\Controllers\UserController::class, 'create'])->name('admin-create');
    Route::post('/admin-store', [App\Http\Controllers\UserController::class, 'store'])->name('admin-store');
    Route::get('/admin-edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('admin-edit');
    Route::put('/admin-update/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('admin-update');
    Route::patch('/admin-status/{id}', [App\Http\Controllers\UserController::class, 'toggleStatus'])->name('admin-status');

    Route::get('/admin-ratings', [App\Http\Controllers\RatingController::class, 'index'])->name('admin-ratings');


    // create category
    Route::get('/admin-category-create', [App\Http\Controllers\CategoryController::class, 'create'])->name('admin-category-create');
    Route::post('/admin-category-store', [App\Http\Controllers\CategoryController::class, 'store'])->name('admin-category-store');
    Route::get('/admin-category-edit/{id}', [App\Http\Controllers\CategoryController::class, 'edit'])->name('admin-category-edit');
    Route::put('/admin-category-update/{id}', [App\Http\Controllers\CategoryController::class, 'update'])->name('admin-category-update');

    // Shops
    Route::get('/admin-shop-create', [App\Http\Controllers\ShopController::class, 'create'])->name('admin-shop-create');
    Route::post('/admin-shop-store', [App\Http\Controllers\ShopController::class, 'store'])->name('admin-shop-store');
    Route::get('/admin-shop-edit/{id}', [App\Http\Controllers\ShopController::class, 'edit'])->name('admin-shop-edit');
    Route::put('/admin-shop-update/{id}', [App\Http\Controllers\ShopController::class, 'update'])->name('admin-shop-update');


        // Service
        Route::get('/admin-service-create', [App\Http\Controllers\ServiceV2Controller::class, 'create'])->name('admin-service-create');
        Route::post('/admin-service-store', [App\Http\Controllers\ServiceV2Controller::class, 'store'])->name('admin-service-store');
        Route::get('/admin-service-edit/{id}', [App\Http\Controllers\ServiceV2Controller::class, 'edit'])->name('admin-service-edit');
        Route::put('/admin-service-update/{id}', [App\Http\Controllers\ServiceV2Controller::class, 'update'])->name('admin-service-update');


        // profile

        Route::get('/admin-edit-profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('admin-edit-profile');

        Route::post('/change-password', [App\Http\Controllers\UserController::class, 'changePassword'])->name('change.password');
        Route::post('/update-field', [App\Http\Controllers\UserController::class, 'updateField'])->name('update.field');
});




Route::get('/rate', function () {
    return view('sample_rate.rate');
});


Route::get('/message-demo', function () {
    return view('message-demo');
});

Route::post('/rate/service', [RatingController::class, 'rateService'])->name('rate.service');
Route::post('/rate/shop', [RatingController::class, 'rateShop'])->name('rate.shop');
Route::post('/rate/technician', [RatingController::class, 'rateTechnician'])->name('rate.technician');

Route::post('/comment/service', [RatingController::class, 'addServiceComment'])->name('comment.service');
Route::post('/comment/reply', [RatingController::class, 'replyToServiceComment'])->name('comment.reply');



Route::post('/api/message/send', [MessageController::class, 'send']);
Route::get('/api/message/inbox', [MessageController::class, 'inbox']);
Route::get('/api/message/conversation/{userId}', [MessageController::class, 'conversation']);
Route::patch('/api/message/read/{id}', [MessageController::class, 'markAsRead']);
Route::get('/api/message/constac', [MessageController::class, 'constac']);




Route::get('/web/clicnt_sokect', [MessageController::class, 'clicnt_sokect']);
Route::post('/web/message/send', [MessageController::class, 'sendWeb']);
Route::get('/web/message/inbox', [MessageController::class, 'inboxWeb']);
Route::get('/web/message/conversation/{userId}', [MessageController::class, 'conversationWeb']);
Route::patch('/web/message/read/{id}', [MessageController::class, 'markAsReadWeb']);

Route::get('/api/search-users', [App\Http\Controllers\UserController::class, 'searchUsers']);
