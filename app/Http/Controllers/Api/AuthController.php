<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    User,
};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Notifications\Otp;

use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;

use App\Traits\ApiResponser;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    use ApiResponser;

    private $verified_code = 123456; // mt_rand(100000,900000);

    /** User login */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email'             =>  'required|email',
            'password'          =>  'required',
            'device_type'       =>  'in:ios,android,web'
        ]);

        $user = User::withTrashed()->where('email', $request->email)->first();

        if (!empty($user)) {
            if ($user->deleted_at != null) {
                return $this->errorDataResponse('Your account has been deleted as per your request.', ['user_id' => $user->id, 'is_deleted' => 1], 400);
            } else {
                if (Hash::check($request->password, $user->password)) {
                    if ($user->is_verified == 1) {
                        if ($user->is_blocked == 0) {
                            Auth::attempt($request->only('email', 'password') + ['is_social' => '0']);

                            $token = $user->createToken('AuthToken');
                            User::whereId($user->id)->update(['device_type' => $request->device_type, 'device_token' => $request->device_token]);
                            $userUpdate = User::find($user->id);

                            $userResource = new UserResource($userUpdate);
                            return $this->loginResponse('User login successfully.', $token->plainTextToken, $userResource);
                        } else {
                            return $this->errorResponse('Your account is blocked.', 400);
                        }
                    } else {
                        $userResource = new UserResource($user);
                        return $this->successDataResponse('Your account is not verfied.', $userResource, 200);
                    }
                } else {
                    return $this->errorResponse('Password is incorrect.', 400);
                }
            }
        } else {
            return $this->errorResponse('Email not found.', 400);
        }


        // $this->validate($request, [
        //     'email'       =>  'required|email'
        // ]);

        // $user = User::withTrashed()->where('email', $request->email)->first();

        // if (empty($user)) { // Register
        //     DB::beginTransaction();
        //     $created =  User::create($request->only('email') + ['verified_code' => $this->verified_code]);

        //     if ($created) {

        //         try {
        //             $created->subject =  'Account Verification';
        //             $created->message =  'Please use the verification code below to sign up. ' . '<br> <br> <b>' . $created->verified_code . '</b>';

        //             Notification::send($created, new Otp($created));
        //         } catch (\Exception $exception) {
        //         }

        //         $data = [
        //             'user_id' => $created->id
        //         ];

        //         DB::commit();
        //         return $this->successDataResponse('Please enter verification', $data, 200);
        //     } else {
        //         DB::rollBack();
        //         return $this->errorResponse('Something went wrong.', 400);
        //     }
        // } else { // Login 
        //     if ($user->deleted_at != null) {
        //         return $this->errorDataResponse('Your account has been deleted as per your request.', ['user_id' => $user->id, 'is_deleted' => 1], 400);
        //     } else {
        //         if ($user->is_verified == 1) {
        //             if ($user->is_blocked == 0) {
        //                 $user->verified_code = $this->verified_code;
        //                 $user->save();
        //                 try {
        //                     $user->subject =  'Sign in Verification';
        //                     $user->message =  'Please use the verification code below to sign in. ' . '<br> <br> <b>' . $user->verified_code . '</b>';

        //                     Notification::send($user, new Otp($user));
        //                 } catch (\Exception $exception) {
        //                 }

        //                 $data = [
        //                     'user_id' => $user->id
        //                 ];
        //                 return $this->successDataResponse('Please enter verification.', $data, 200);
        //             } else {
        //                 return $this->errorResponse('Your account is blocked.', 400);
        //             }
        //         } else {
        //             $data = [
        //                 'user_id' => $user->id
        //             ];
        //             return $this->successDataResponse('Your account is not verfied.', $data, 200);
        //         }
        //     }
        // }
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'email'       =>  'required|email|max:255',
            'password'    =>  'required'
        ]);

        $user = User::withTrashed()->where('email', $request->email)->first();

        if (!empty($user)) {
            if ($user->deleted_at != null) {
                return $this->errorDataResponse('Your account has been deleted as per your request.', ['user_id' => $user->id, 'is_deleted' => 1], 400);
            } elseif ($user->email == $request->email) {
                return $this->errorResponse('The email already has been taken.', 400);
            }
        } else {
            $created =  User::create($request->only('email', 'password') + ['verified_code' => $this->verified_code]);

            if ($created) {

                try {
                    $created->subject =  'User Account Verification';
                    $created->message =  'Please use the verification code below to sign up. ' . '<b>' . $created->verified_code . '</b>';

                    Notification::send($created, new Otp($created));
                } catch (\Exception $exception) {
                }

                $data = [
                    'user_id' => $created->id
                ];
                return $this->successDataResponse('User register successfully.', $data, 200);
            } else {
                return $this->errorResponse('Something went wrong.', 400);
            }
        }
    }

    /** Complete profile */
    public function completeProfile(Request $request)
    {
        $this->validate($request, [
            'profile_image ' => 'mimes:jpeg,png,jpg',
            'full_name' => 'required',
            'phone_number'  => 'nullable|unique:users,phone_number', // Phone number is now optional
            'gender' => 'in:male,female,other',
            'date_of_birth' => 'required|date',
        ]);

        try {
            $authUser = auth()->user();
            $authId = $authUser->id;
            $completeProfile = $request->only(
                'full_name',
                'gender',
                'profile_image',
                'phone_number',
                'date_of_birth',
                'country',
                'state',
                'city',
                'zip_code',
                'address',
                'country_code',
                'country_iso_code',
                'location',
                'latitude',
                'longitude',
            );

            if ($request->hasFile('profile_image')) {
                $profile_image = strtotime("now") . mt_rand(100000, 900000) . '.' . $request->profile_image->getClientOriginalExtension();
                $request->profile_image->move(public_path('/media/profile_image'), $profile_image);
                $file_path = '/media/profile_image/' . $profile_image;
                $completeProfile['profile_image'] = $file_path;
            }

            // If phone number is not provided, remove it from the update array
            if (empty($completeProfile['phone_number'])) {
                unset($completeProfile['phone_number']);
            }

            $completeProfile['is_profile_complete'] = '1';
            $update_user = User::whereId($authId)->update($completeProfile);

            if ($update_user) {
                $user = User::find($authId);
                $userResource = new UserResource($user);
                return $this->successDataResponse('Profile completed successfully.', $userResource);
            } else {
                return $this->errorResponse('Something went wrong.', 400);
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    // Preferences
    public function createPreferences(Request $request)
    {

        $authUser = auth()->user();
        $authId = $authUser->id;

        $completeProfile['preferences'] = json_encode($request->preferences);

        $update_user = User::whereId($authId)->update($completeProfile);
        if ($update_user) {
            $user = User::find($authId);
            $userResource = new UserResource($user);

            if ($authUser->is_profile_complete == '1') {
                return $this->successDataResponse('Preferences Added successfully.', $userResource);
            } else {
                return $this->successDataResponse('Preferences Added successfully.', $userResource);
            }
        } else {
            return $this->errorResponse('Something went wrong.', 400);
        }
    }

    // createMemberPreferences
    public function createMemberPreferences(Request $request)
    {
        $authUser = auth()->user();
        $authId = $authUser->id;

        $completeProfile['member_preferences'] = json_encode($request->member_preferences);

        $update_user = User::whereId($authId)->update($completeProfile);
        if ($update_user) {
            $user = User::find($authId);
            $userResource = new UserResource($user);

            if ($authUser->is_profile_complete == '1') {
                return $this->successDataResponse('Representative preferences Added successfully.', $userResource);
            } else {
                return $this->successDataResponse('Representative preferences Added successfully.', $userResource);
            }
        } else {
            return $this->errorResponse('Something went wrong.', 400);
        }
    }


    /** Social login */
    public function socialLogin(Request $request)
    {
        $this->validate($request, [
            'social_type'       =>  'required|in:google,apple,facebook,phone',
            'social_token'      =>  'required',
            // 'password'      =>  'required',
            'device_type'       =>  'in:ios,android,web',
        ]);

        try {
            DB::beginTransaction();
            $user = User::withTrashed()->where('social_token', $request->social_token)->first();

            if (!empty($user)) {
                if ($user->deleted_at == null) {
                    if ($user->is_blocked == 0) {
                        $user->device_type = $request->device_type;
                        $user->device_token = $request->device_token;
                        $user->save();
                    } else {
                        return $this->errorResponse('Your account is blocked.', 400);
                    }
                } else {
                    return $this->errorDataResponse('Your account has been deleted as per your request.', ['user_id' => $user->id, 'is_deleted' => 1], 400);
                }
            } else {
                $user = new User;
                $user->social_type = $request->social_type;
                $user->social_token = $request->social_token;
                $user->phone_number = $request->phone_number;
                $user->is_verified = '1';
                $user->is_social = '1';
                $user->is_profile_complete = '0';
                $user->device_type = $request->device_type;
                $user->device_token = $request->device_token;
                $user->save();
            }

            $token = $user->createToken('AuthToken');
            $user = User::whereId($user->id)->first();
            $userResource = new UserResource($user);

            DB::commit();
            $message = 'Social login successfully.';
            if ($request->social_type == 'phone') {
                $message = 'Phone login success.';
            }
            return $this->loginResponse($message, $token->plainTextToken, $userResource);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }

    /** Verification */
    public function verification(Request $request)
    {
        $this->validate($request, [
            'user_id'       => 'required|exists:users,id',
            'verified_code' => 'required',
            'type'          => 'required|in:forgot,account_verify',
            'device_type'   =>  'in:ios,android,web'
        ]);

        $userExists = User::whereId($request->user_id)->where('verified_code', $request->verified_code)->exists();

        if ($userExists) {
            if ($request->type == 'forgot') {
                $updateUser = User::whereId($request->user_id)->where('verified_code', $request->verified_code)->update(['device_type' => $request->device_type, 'device_token' => $request->device_token, 'is_forgot' => '1', 'verified_code' => null]);
            } else {
                $updateUser = User::whereId($request->user_id)->where('verified_code', $request->verified_code)->update(['device_type' => $request->device_type, 'device_token' => $request->device_token, 'is_verified' => '1', 'verified_code' => null]);
            }

            if ($updateUser) {
                $user = User::find($request->user_id);
                $token = $user->createToken('AuthToken');

                $userResource = new UserResource($user);
                return $this->loginResponse('Your verification completed successfully.', $token->plainTextToken, $userResource);
            } else {
                return $this->errorResponse('Something went wrong.', 400);
            }
        } else {
            return $this->errorResponse('Invalid OTP.', 400);
        }
    }

    /** Resend code */
    public function reSendCode(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|exists:users,id'
        ]);

        $user = User::whereId($request->user_id)->first();
        $user->verified_code = $this->verified_code;

        if ($user->save()) {
            return $this->successResponse('We have resend OTP verification code at your email address.', 200);
        } else {
            return $this->errorResponse('Something went wrong.', 400);
        }
    }

    /** Logout */
    public function logout(Request $request)
    {
        $user_id = auth()->user()->id;
        $user_obj = User::whereId($user_id)->count();

        if ($user_obj > 0) {

            $deleteTokens = $request->user()->currentAccessToken()->delete();
            if ($deleteTokens) {
                $update_user = User::whereId($user_id)->update(['device_type' => null, 'device_token' => null]);

                if ($update_user) {
                    return $this->successResponse('User logout successfully.');
                } else {
                    $this->errorResponse('Sorry there is some problem while updating user data.', 400);
                }
            } else {
                return $this->errorResponse('Something went wrong.', 400);
            }
        } else {
            return $this->errorResponse('User not found', 404);
        }
    }

    /** Delete account */
    public function deleteAccount()
    {
        try {
            DB::beginTransaction();
            User::whereId(auth()->id())->update(['device_type' => null, 'device_token' => null]);
            $user = User::whereId(auth()->id())->first();
            $user->tokens()->delete();
            $user->delete();

            DB::commit();
            return $this->successResponse('Account has been deleted successfully.', 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }

    /** Forgot password */
    public function forgotPassword(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::where('email', $request->email)->first();
        $user->verified_code = $this->verified_code;
        $user->is_forgot = '1';

        if ($user->save()) {

            try {
                $user->subject =  'Forgot Your Password';
                $user->message =  'We received a request to reset the password for your account. Please use the verification code below to change password.' . '<br> <br> <b>' . $user->verified_code . '</b>';

                // Notification::send($user, new Otp($user));
            } catch (\Exception $exception) {
            }

            $data = [
                'user_id' => $user->id
            ];
            return $this->successDataResponse('Verification code has been sent on your email address', $data, 200);
        } else {
            return $this->errorResponse('Something went wrong.', 400);
        }
    }
    // Update Password
    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'new_password' => 'required|max:255|min:8'
        ]);

        if (empty($request->old_password)) {
            $updateUser = User::whereId(auth()->user()->id)->update(['password' => Hash::make($request->new_password), 'is_forgot' => '0']);
            if ($updateUser) {
                return $this->successResponse('New Password set successfully.', 200);
            } else {
                return $this->errorResponse('Something went wrong.', 400);
            }
        } else {
            $user = User::whereId(auth()->user()->id)->first();
            if (Hash::check($request->old_password, $user->password)) {
                $updateUser = User::whereId(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);
                if ($updateUser) {
                    return $this->successResponse('Password update successfully.', 200);
                } else {
                    return $this->errorResponse('Something went wrong.', 400);
                }
            } else {
                return $this->errorResponse('Old password is incorrect.', 400);
            }
        }
    }
}
