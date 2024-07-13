<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendOTP;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthUserController extends Controller
{

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'f_name' => 'required|string|max:255',
                'l_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'address' => 'nullable|string',
                'city' => 'nullable|string|max:255',
                'phone_number' => 'nullable|string|max:20',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $user = User::create([
                'f_name' => $request->f_name,
                'l_name' => $request->l_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'address' => $request->address,
                'city' => $request->city,
                'phone_number' => $request->phone_number,
                'verified' => 0,
            ]);


            $token = mt_rand(1000, 9999);
            $user->otp = $token;
            $user->save();

            $data = [
                "pin" => $token,
            ];
            Mail::to($user->email)->send(new SendOTP($data));

            return response()->json([
                'message' => 'OTP sent to email ' . $user->email,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid email or password.',
                ], 401);
            }

            if (!$user->verified) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email is not verified.',
                ], 403);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // Verify OTP
    public function verifyOtp(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255',
                'otp' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $user = User::where('email', $request->email)->where('otp', $request->otp)->first();

            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid OTP or email.',
                ], 400);
            }

            $user->verified = true;
            $user->otp = null;
            $user->save();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Email verified successfully.',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // Forgot Password
    public function forgotPassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email does not exist.',
                ], 404);
            }

            $token = mt_rand(1000, 9999);
            $user->otp = $token;
            $user->save();

            $data = [
                "pin" => $token,
            ];
            Mail::to($user->email)->send(new SendOTP($data));

            return response()->json([
                'message' => 'OTP sent to email ' . $user->email,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


     // Reset Password
     public function resetPassword(Request $request)
     {
         try {
             $validator = Validator::make($request->all(), [
                 'email' => 'required|string|email|max:255',
                 'otp' => 'required|integer',
                 'password' => 'required|string|min:8|confirmed',
             ]);

             if ($validator->fails()) {
                 return response()->json($validator->errors(), 422);
             }

             $user = User::where('email', $request->email)->where('otp', $request->otp)->first();

             if (!$user) {
                 return response()->json([
                     'status' => 'error',
                     'message' => 'Invalid OTP or email.',
                 ], 400);
             }

             $user->password = Hash::make($request->password);
             $user->otp = null;
             $user->save();

             return response()->json([
                 'message' => 'Password reset successfully.',
             ], 200);

         } catch (\Exception $e) {
             return response()->json([
                 'status' => 'error',
                 'message' => $e->getMessage(),
             ], 500);
         }
     }

}
