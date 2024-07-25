<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UsersController;





Route::controller(UsersController::class)->group(function () {
    Route::get('/', 'RegisterForm')->name('register');
    Route::get('/login', 'LoginForm')->name('login');
    Route::get('/profile', 'Profile')->name('profile');
    Route::get('verify-email/{token}', 'VerifyEmail')->name('verify_email');
});
