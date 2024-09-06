<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendOTP;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AuthUserController extends Controller
{

    public function register(Request $request)
    {
        try {
                $validator = Validator::make($request->all(), [
                'f_name' => 'required|string|max:255',
                'l_name' => 'nullable|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'username' => 'required|string|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'address' => 'nullable|string',
                'city' => 'nullable|string|max:255',
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

            $user = User::create([
                'f_name' => $request->f_name,
                'l_name' => $request->l_name,
                'email' => filter_var($request->email, FILTER_VALIDATE_EMAIL) ? $request->email : null,
                'username' => filter_var($request->username, FILTER_VALIDATE_EMAIL) ? null : $request->username,
                'password' => Hash::make($request->password),
                'address' => $request->address,
                'city' => $request->city,
                'phone_number' => $request->phone_number,
                'verified' => 0,
            ]);


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

            $user = User::where(function ($query) use ($request) {
            $query->where('email', $request->login)
                  ->orWhere('username', $request->login);
              })->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid email or password.',
                ], 401);
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
                    return response()->json(
                        [
                    'status' => 'error',
                    'message' => $validator->errors(),
                ]
               , 422);
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
                    return response()->json(
                        [
                    'status' => 'error',
                    'message' => $validator->errors(),
                ]
               , 422);
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
                    return response()->json(
                        [
                    'status' => 'error',
                    'message' => $validator->errors(),
                ]
               , 422);
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

             $user=User::where('id',$id)->first();

             $user->f_name = $request->f_name;
             $user->l_name = $request->l_name;
             $user->address = $request->address;
             $user->city = $request->city;
             $user->phone_number = $request->phone_number;
             $user->further_information=$request->further_information;
             $user->governorate=$request->governorate;
             $user->locality=$request->locality;
             $user->region=$request->region;
             $user->birth_day=$request->birth_day;
             if ($request->hasFile('image')) {

                if ($user->image) {
                    Storage::delete(str_replace('/storage', 'public', $user->image));
                }

                $ProfileName = "FEE";
                $imageFile = $request->file('image');
                $imageUniqueName = uniqid();
                $imageExtension = $imageFile->getClientOriginalExtension();
                $imageFilename = $ProfileName . Carbon::now()->format('Ymd') . '_' . $imageUniqueName . '.' . $imageExtension;
                $imagePath = $imageFile->storeAs('public/upload/files/image/', $imageFilename);
                $imageUrl = Storage::url('upload/files/image/' . $imageFilename);

                $user->image = $imageUrl;
            }


             $user->save();

             return response()->json([
                 'message' => 'Profile updated successfully.',
                 'user' => $user,
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

             $user=User::where('id',$id)->first();

             if (!Hash::check($request->old_password, $user->password)) {
                 return response()->json([
                     'status' => 'error',
                     'message' => 'Invalid old password.',
                 ], 401);
             }

             $user->password = Hash::make($request->password);
             $user->save();

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
                 'username' => 'required|string|max:255|unique:users'
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

             $user=User::where('id',$id)->first();

             $user->username = $request->username;
             $user->save();

             return response()->json([
                 'message' => 'Username changed successfully.',
                 'user' => $user,
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
             $user = User::where('id', $id)->first();

             if (!$user->image) {
                 return response()->json([
                     'status' => 'error',
                     'message' => 'No image found.',
                 ], 404);
             }

             Storage::delete(str_replace('/storage', 'public', $user->image));
             $user->image = null;
             $user->save();

             return response()->json([
                 'message' => 'Image deleted successfully.',
                 'user' => $user,
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
             $user = User::where('id', $id)
                 ->with('orders.products.images.designer.categories', 'cart.products.images.designer.categories')
                 ->first();

             if (!$user) {
                 return response()->json([
                     'status' => 'error',
                     'message' => 'User not found.',
                 ], 404);
             }

             return response()->json([
                 'user' => $user,
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
