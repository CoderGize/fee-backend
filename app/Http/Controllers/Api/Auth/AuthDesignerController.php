<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendOTP;
use App\Models\Designer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AuthDesignerController extends Controller
{

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'f_name' => 'required|string|max:255',
                'l_name' => 'nullable|string|max:255',
                'email' => 'required|string|email|max:255|unique:designers',
                'username' => 'required|string|max:255|unique:designers',
                'password' => 'required|string|min:8|confirmed',
                'address' => 'nullable|string',
                'city' => 'nullable|string',
                'phone_number' => 'nullable|string|max:20',
            ]);

            if ($validator->fails()) {
                    return response()->json(
                        [
                    'status' => 'error',
                    'message' => $validator->errors(),
                ]
               , 422);
                }

            $designer = Designer::create([
                'f_name' => $request->f_name,
                'l_name' => $request->l_name,
                'email' => filter_var($request->email, FILTER_VALIDATE_EMAIL) ? $request->email : null,
                'username' => filter_var($request->username, FILTER_VALIDATE_EMAIL) ? null : $request->username,
                'password' => Hash::make($request->password),
                'address' => $request->address,
                'city' => $request->city,
                'phone_number' => $request->phone_number,
            ]);


            $token = $designer->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'designer' => $designer,
            ], 200);


        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'login' => 'required|string',
                'password' => 'required|string',
                 ]);
                if ($validator->fails()) {
                    return response()->json(
                        [
                    'status' => 'error',
                    'message' => $validator->errors(),
                ]
               , 422);
                }

            $designer = Designer::where('email', $request->email)->first();

            if (!$designer || !Hash::check($request->password, $designer->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid email or password.',
                ], 401);
            }



            $token = $designer->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'designer' => $designer,
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
                    return response()->json(
                        [
                    'status' => 'error',
                    'message' => $validator->errors(),
                ]
               , 422);
                }

            $designer = Designer::where('email', $request->email)->where('otp', $request->otp)->first();

            if (!$designer) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid OTP or email.',
                ], 400);
            }

            $designer->verified = true;
            $designer->otp = null;
            $designer->save();

            $token = $designer->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Email verified successfully.',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'designer' => $designer,
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
                    return response()->json(
                        [
                    'status' => 'error',
                    'message' => $validator->errors(),
                ]
               , 422);
                }

            $designer = Designer::where('email', $request->email)->first();

            if (!$designer) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email does not exist.',
                ], 404);
            }

            $token = mt_rand(1000, 9999);
            $designer->otp = $token;
            $designer->save();

            $data = [
                "pin" => $token,
            ];
            Mail::to($designer->email)->send(new SendOTP($data));

            return response()->json([
                'message' => 'OTP sent to email ' . $designer->email,
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
                    return response()->json(
                        [
                    'status' => 'error',
                    'message' => $validator->errors(),
                ]
               , 422);
                }

            $designer = Designer::where('email', $request->email)->where('otp', $request->otp)->first();

            if (!$designer) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid OTP or email.',
                ], 400);
            }

            $designer->password = Hash::make($request->password);
            $designer->otp = null;
            $designer->save();

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


    // Update Profile
    public function updateProfile(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'f_name' => 'required|string|max:255',
                'l_name' => 'nullable|string|max:255',
                'address' => 'nullable|string',
                'city' => 'nullable|string',
                'phone_number' => 'nullable|string|max:20',
            ]);

            if ($validator->fails()) {
                    return response()->json(
                        [
                    'status' => 'error',
                    'message' => $validator->errors(),
                ]
               , 422);
                }

            $id = Auth::id();

            $designer=Designer::where('id',$id)->first();

            $designer->f_name = $request->f_name;
            $designer->l_name = $request->l_name;
            $designer->address = $request->address;
            $designer->city = $request->city;
            $designer->phone_number = $request->phone_number;


            if ($request->hasFile('image')) {

                if ($designer->image) {
                    Storage::delete(str_replace('/storage', 'public', $designer->image));
                }

                $ProfileName = "FEE";
                $imageFile = $request->file('image');
                $imageUniqueName = uniqid();
                $imageExtension = $imageFile->getClientOriginalExtension();
                $imageFilename = $ProfileName . Carbon::now()->format('Ymd') . '_' . $imageUniqueName . '.' . $imageExtension;
                $imagePath = $imageFile->storeAs('public/upload/files/image/', $imageFilename);
                $imageUrl = Storage::url('upload/files/image/' . $imageFilename);

                $designer->image = $imageUrl;
            }
            $designer->save();

            return response()->json([
                'message' => 'Profile updated successfully.',
                'designer' => $designer,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // Change Password
    public function changePassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'old_password' => 'required|string',
                'password' => 'required|string|min:8|confirmed',
            ]);

           if ($validator->fails()) {
                    return response()->json(
                        [
                    'status' => 'error',
                    'message' => $validator->errors(),
                ]
               , 422);
                }

            $id = Auth::id();

            $designer=Designer::where('id',$id)->first();

            if (!Hash::check($request->old_password, $designer->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid old password.',
                ], 401);
            }

            $designer->password = Hash::make($request->password);
            $designer->save();

            return response()->json([
                'message' => 'Password changed successfully.',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // Change Username (Email)
    public function changeUsername(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'username' => 'required|string|max:255,'
            ]);

            if ($validator->fails()) {
                    return response()->json(
                        [
                    'status' => 'error',
                    'message' => $validator->errors(),
                ]
               , 422);
                }

            $id = Auth::id();

            $designer=Designer::where('id',$id)->first();

            $designer->username = $request->username;
            $designer->save();

            return response()->json([
                'message' => 'Username changed successfully.',
                'designer' => $designer,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function deleteImage()
    {
        try {
            $id = Auth::id();
            $designer = Designer::where('id', $id)->first();

            if (!$designer->image) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No image found.',
                ], 404);
            }

            Storage::delete(str_replace('/storage', 'public', $designer->image));
            $designer->image = null;
            $designer->save();

            return response()->json([
                'message' => 'Image deleted successfully.',
                'designer' => $designer,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getUserWithData()
    {
        try {
            $id = Auth::id();
            $designer = Designer::where('id', $id)
                ->with('products.images.designer.categories')
                ->first();

            if (!$designer) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'designer not found.',
                ], 404);
            }

            return response()->json([
                'designer' => $designer,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            Auth::logout();
            return response()->json([
                'message' => 'Logged out successfully.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
