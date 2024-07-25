<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\User;


class UsersController extends Controller
{
    function RegisterForm()
    {
        return view('register');
    }


    function LoginForm()
    {
        return view('login');
    }

    function Profile()
    {
        return view('profile');
    }

    function VerifyEmail($token)
    {
        try {
            $user = User::where('remember_token', $token)->first();
            if ($user) {
                $currentDateTime = Carbon::now()->format('Y-m-d H:i:s');
                $user->email_verified_at = $currentDateTime;
                $user->is_verified = 1;
                $user->remember_token = '';
                $user->save();
                return response()->json([
                    'success' => true, 'msg' => 'Your email is verified',
                ], 200);
            } else {
                return "<h1 style='text-align:center;'>Not Found !.</h1>";
            }
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'error' => $th->getMessage()]);
        }
    }
}
