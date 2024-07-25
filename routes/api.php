<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApiControllers;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::controller(ApiControllers::class)->group(function () {
    Route::post('registrations', 'Registeration')->name('registered');
    Route::post('login', 'Login')->name('login');
    Route::get('logout', 'Logout')->name('logout');
});


Route::middleware(['middleware' => 'auth'])->group(function () {
    // Route::prefix('/user/')->group(function () {
    Route::controller(ApiControllers::class)->group(function () {
        Route::get('profile', 'Profile')->name('profile');
        Route::put('update-profile', 'UpdateProfile')->name('update_profile');
        Route::get('send-email-verify/{id}', 'SendEmail')->name('send_email');
        // Route::get('verify-email/{token}', 'VerifyEmail')->name('verify_email');
        Route::get('refresh-token', 'RefreshToken')->name('refr_token');


        // });
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
