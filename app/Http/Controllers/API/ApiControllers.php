<?php

namespace App\Http\Controllers\API;

use Validator;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Dotenv\Validator as DotenvValidator;

class ApiControllers extends Controller
{
    function Registeration(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'username' => 'required|string|min:3|max:30',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|string|min:8|same:password'
            // 'password' => 'required|string|min:8|confirmed'
        ]);
        DB::beginTransaction();
        try {
            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 403);
            }

            User::create([
                'name' => $req->username, 'email' => $req->email,
                'password' => $req->password, 'password_confirmation' => $req->password_confirmation
            ]);
            DB::commit();
            return response()->json(['success' => true, 'msg' => 'User registered successfully!.']);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'errors' => $th->getMessage()]);
        }
    }

    function Login(Request $req)
    {
        $token = '';
        $validator = Validator::make($req->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);

        try {
            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 403);
            }

            if (!$token = auth()->attempt($validator->validated())) {
                return response()->json(['success' => false, 'error' => 'Credentials are invalid!.']);
            }
            return $this->responseWithToken($token);
            // return response()->json(['success' => true, 'msg' => 'User loged in successfully!.', 'token' => $token]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'errors' => $th->getMessage()]);
        }
    }

    protected function responseWithToken($token)
    {
        return response()->json([
            'success' => true,
            // 'msg' => 'User loged in successfully!.',
            'access_token' => $token,
            'token_type' => 'Bearer', 'expires_in' => JWTAuth::factory()->getTTL() * 5
        ]);
    }


    function Logout()
    {
        try {
            auth()->logout();
            return response()->json(['success' => true, 'msg' => 'Logout successfull!.']);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'error' => $th->getMessage()]);
        }
    }


    function Profile()
    {
        try {
            $user = [];
            $user = auth()->user()->select('id', 'name', 'email', 'is_verified')->first();
            $updatedAt = auth()->user()->updated_at;
            $update_at = Carbon::parse($updatedAt)->format('d-m-Y H:i:s');
            $user['update_at'] = $update_at;
            return response()->json(['success' => true, 'data' => $user]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'errors' => $th->getMessage()]);
        }
    }


    function UpdateProfile(Request $req)
    {
        try {
            $validator = Validator::make($req->all(), [
                'id' => 'required|string',
                'name' => 'required|string|min:3|max:30',
                'email' => 'required|string|email',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 403);
            }
            $user = User::find($req->id);
            $user->name = $req->name;
            $user->email = $req->email;
            $user->is_verified = 0;
            $user->save();
            return response()->json(['success' => true, 'msg' => 'Your profile is updated!.']);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'errors' => $th->getMessage()]);
        }
    }

    function SendEmail($email)
    {
        try {
            $user = User::where('email', $email)->first();
            if ($user) {
                $random = Str::random(60);
                $domain = URL::to('/');
                $full_url = $domain . '/verify-email/' . $random;
                $data['url'] = $full_url;

                $data['title'] = 'Email verification';
                $data['body'] = 'Click below to verify the email';
                $data['email'] = $email;
                Mail::send('verify_email', compact('data'), function ($message) use ($data) {
                    $message->to($data['email'])->subject($data['title']);
                });
                $user->remember_token = $random;
                $user->save();
                return response()->json([
                    'success' => true, 'msg' => "Mail Sent Successfully, Please Verify it!.",
                    'data' => $email, 'user' => $full_url
                ], 200);
            }
            return response()->json(['success' => false, 'error' => 'User not found'], 404);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'error' => $th->getMessage()]);
        }
    }
    function RefreshToken()
    {
        try {
            return $this->responseWithToken(auth()->refresh());
            // return response()->json(['success' => true, 'msg' => 'Refresh token']);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'error' => $th->getMessage()]);
        }
    }
}
