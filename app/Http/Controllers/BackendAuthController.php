<?php

namespace App\Http\Controllers;

use App\Helper\CustomSanitize;
use App\Helper\FetchCurrentAdmin;
use App\Helper\JWTToken;
use App\Helper\ResponseHelper;
use App\Models\Admin;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class BackendAuthController extends Controller
{
    // Login function
    public function Login(Request $request)
    {
        try {
            // Request Validation
            $request->validate([
                'username' => 'required',
                'password' => 'required',
            ]);
            // Sanitize input
            $username = CustomSanitize::sanitize($request->input('username'));
            $password = CustomSanitize::sanitize($request->input('password'));

            // Find admin by username
            $admin = Admin::where('username', $username)->first();
            if ($admin) {
                // Check if the password matches
                if (!Hash::check($password, $admin->password)) {
                    return ResponseHelper::Out('error', 'Username & Password Not Matched', null, 200);
                } else {
                    // check status
                    if ($admin->status == 'Inactive') {
                        return ResponseHelper::Out('error', 'Your Account is Inactive', null, 200);
                    } elseif ($admin->status == 'Locked') {
                        return ResponseHelper::Out('error', 'Your Account is Locked', null, 200);
                    } elseif ($admin->status == 'Unverified') {
                        return ResponseHelper::Out('error', 'Your Account is Unverified', null, 200);
                    }
                    $token = JWTToken::CreateToken($admin->username, $admin->id, $request);
                    // Set the token in the cookie
                    return ResponseHelper::Out('success', 'Login Successful', null, 200)
                        ->cookie('l_token', $token, 180, '/', null, true, true, false, 'Strict');
                }
            } else {
                return ResponseHelper::Out('error', 'Username & Password Not Matched', null, 200);
            }
        } catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| BackendAuthController--Login ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // Logout function
    public function BackendLogout(Request $request)
    {
        try {
            $data = JWTToken::ReadToken($request->cookie('l_token'));

            if ($data == 'unauthorized') {
                return redirect(route('Login'))
                    ->withCookie(cookie('l_token', '', -1, '/', null, true, true, false, 'Strict'));
            }

            // Update token field to null in database
            Admin::where('id', $data->userID)->update(['token' => null]);

            // Redirect to login and delete cookie
            return redirect(('login'))
                ->withCookie(cookie('l_token', '', -1, '/', null, true, true, false, 'Strict'));

        } catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| BackendAuthController--BackendLogout ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // Profile function
    public function Profile(Request $request)
    {
        try {
            $data = FetchCurrentAdmin::GetCurrentAdmin($request);
            // Find admin by ID
            $admin = Admin::find($data->userID);
            if ($admin) {
                return ResponseHelper::Out('success', 'Profile Found', $admin, 200);
            } else {
                return ResponseHelper::Out('error', 'Profile Not Found', null, 200);
            }
        } catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| BackendAuthController--Profile ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // Profile Update function
    public function ProfileUpdate(Request $request)
    {
        try {
            // Request Validation
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'last_name' => 'required|string|max:255',
                'gender' => 'nullable|string|in:Male,Female,Other',
                'dob' => 'nullable|date',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $admin = FetchCurrentAdmin::GetCurrentAdmin($request);

            if (!$admin) {
                return ResponseHelper::Out('error', 'Admin not found', null, 404);
            }
            $admin = Admin::find($admin->userID);

            // Update profile fields
            $admin->first_name = CustomSanitize::sanitize($request->input('first_name'));
            $admin->middle_name = CustomSanitize::sanitize($request->input('middle_name'));
            $admin->last_name = CustomSanitize::sanitize($request->input('last_name'));
            $admin->gender = CustomSanitize::sanitize($request->input('gender'));
            $admin->dob = CustomSanitize::sanitize($request->input('dob'));

            // Handle profile image
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($admin->image) {
                    $oldImagePath = public_path('assets/uploads/profile/' . $admin->image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                // Save new image
                $image = $request->file('image');
                $imageName = 'profile_' . $admin->id . '_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('assets/uploads/profile/'), $imageName);
                $admin->image = $imageName;
            }

            $admin->save();

            return ResponseHelper::Out('success', 'Profile Updated Successfully', null,200);
        } catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| BackendAuthController--ProfileUpdate ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // Change Password function
    public function ChangePassword(Request $request)
    {
        try {
            // validate data
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:6',
            ]);
            $data = FetchCurrentAdmin::GetCurrentAdmin($request);
            // Find admin by ID
            $admin = Admin::find($data->userID);
            if ($admin) {
                // Check if the old password matches
                if (!Hash::check(CustomSanitize::sanitize($request->input('current_password')), $admin->password)) {
                    return ResponseHelper::Out('error', 'Current Password Not Matched', null, 200);
                } else {
                    // Update password
                    $admin->password = Hash::make(CustomSanitize::sanitize($request->input('new_password')));
                    $admin->save();
                    return ResponseHelper::Out('success', 'Password Changed Successfully', null, 200);
                }
            } else {
                return ResponseHelper::Out('error', 'Profile Not Found', null, 200);
            }
        } catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| BackendAuthController--ChangePassword ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // Forgot password function
    public function Forgot(Request $request)
    {
        try {
            // Validate request
            $request->validate([
                'secret_code' => 'required',
            ]);
            // Sanitize Secret Code
            $secret_code = CustomSanitize::sanitize($request->input('secret_code'));
            $key_code = 'RAWITSOLUTIONS@@##POS';
            if( $secret_code !== $key_code) {
                return ResponseHelper::Out('error', 'Invalid Secret Code', null, 200);
            } else {
                // Generate a new verification code
                $token = rand(100000, 999999);
                $admin = Admin::where('username', 'superadmin')->first();
                if (!$admin) {
                    return ResponseHelper::Out('error', 'Admin not found', null, 200);
                }
                // Update the admin's forgot token
                $admin->token = $token;
                $admin->save();
                // verify the token
                return ResponseHelper::Out('success', 'Successfully Verified', null, 200);
            }
        } catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| BackendAuthController--Forgot ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // Reset password function
    public function Reset(Request $request)
    {
        try {
            // Validate request
            $request->validate([
                'password' => 'required|min:6',
                'confirmPassword' => 'required',
            ]);
            // Sanitize Secret Code
            $password = CustomSanitize::sanitize($request->input('password'));
            $confirmPassword = CustomSanitize::sanitize($request->input('confirmPassword'));
            if ($password !== $confirmPassword) {
                return ResponseHelper::Out('error', 'Password & Confirm Password Not Matched', null, 200);
            }
            // Check if forgot token exists
            $admin = Admin::where('username', 'superadmin')->first();
            $admin->token = '';
            $admin->password = Hash::make($password);
            $admin->save();
            return ResponseHelper::Out('success', 'Password Reset Successfully', null, 200);
        } catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| BackendAuthController--Reset ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }





}
