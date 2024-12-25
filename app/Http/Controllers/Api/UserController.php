<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Http\Resources\UserResource;
use App\Models\{
    User
};

class UserController extends Controller
{
    use ApiResponser;

    /****** Update User Profile *****/
    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'profile_image ' => 'mimes:jpeg,png,jpg',
            'full_name' => 'required',
            'phone_number'  => 'required',
            'gender' => 'in:male,female,other',
            'date_of_birth' => 'required|date',
        ]);

        $authId = auth()->user()->id;
        try {

            $check = User::where('id', '!=', $authId)->where('phone_number', $request->phone_number)->get();
            if (count($check) > 0) {
                return $this->errorResponse('Phone number should be unique.', 400);
            }

            $completeProfile = $request->only(
                'full_name',
                'gender',
                'profile_image',
                'phone_number',
                'date_of_birth',
                'about',
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

            $update_user = User::whereId($authId)->update($completeProfile);

            if ($update_user) {
                $user = User::find($authId);
                $userResource = new UserResource($user);
                return $this->successDataResponse('Profile updated successfully.', $userResource);
            } else {
                return $this->errorResponse('Something went wrong.', 400);
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }
}
