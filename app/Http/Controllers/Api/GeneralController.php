<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    User,
    Preference,
    Member,
    Quote,
    MyRight,
    SaveMyRight,
    Setting,
    WhiteHouseDetail,
    CongressDetail,
    HelpAndFeedBack,
    NationalDebt,
    BudgetFunction,
    HouseDetail,
    SenateDetail,
    Notification,
    BillOfRight
};
use Illuminate\Support\Facades\DB;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\Members\MemberResource;
use Carbon\Carbon;

class GeneralController extends Controller
{
    use ApiResponser;

    final public function enableNotifications(Request $request)
    {
        $user = auth()->user();
        $authId = $user->id;

        if ($user->push_notification == '1') {
            $update_user = User::whereId($authId)->update(['push_notification' => '0']);
            if ($update_user) {
                return $this->successResponse('Notifications Disabled Successfully', 200);
            } else {
                return $this->errorResponse('Something went wrong.', 400);
            }
        } else if ($user->push_notification == '0') {
            $update_user = User::whereId($authId)->update(['push_notification' => '1']);
            if ($update_user) {
                return $this->successResponse('Notifications Enabled Successfully', 200);
            } else {
                return $this->errorResponse('Something went wrong.', 400);
            }
        }
    }

    /** List notification */
    public function notificationList(Request $request)
    {
        $this->validate($request, [
            'offset' => 'required|numeric'
        ]);

        $notifications = Notification::where('receiver_id', auth()->id());
        $notificationCount = $notifications->count();
        $notifications = $notifications->latest()->skip($request->offset)->take(10)->get();

        if (count($notifications) > 0) {
            $data = [
                'total_notifications' => $notificationCount,
                'notifications'       => $notifications
            ];
            Notification::where(['receiver_id' => auth()->id(), 'read_at' => null, 'seen' => '0'])->update(['read_at' => now(), 'seen' => '1']);
            return $this->successDataResponse('Notification list found.', $data, 200);
        } else {
            return $this->errorResponse('Notification list not found.', 400);
        }
    }

    // /** Unread notification count */
    public function notificationUnreadCount()
    {
        $count = Notification::where(['receiver_id' => auth()->id(), 'read_at' => null, 'seen' => '0'])->count();
        return $this->successDataResponse('Notification count.', ['notification_count' => $count]);
    }

    /** Delete notification */
    public function notificationDelete(Request $request)
    {
        $this->validate($request, [
            'notification_id' => 'required|exists:notifications,id'
        ]);

        try {
            DB::beginTransaction();
            Notification::whereId($request->notification_id)->delete();

            DB::commit();
            return $this->successResponse('Notification has been deleted successfully.');
        } catch (\Exception $exception) {
            DB::rollBack();
            return $exception->getMessage();
        }
    }

    // Alert Notification Enable & Disable
    final public function alertEnableNotifications(Request $request)
    {
        $user = auth()->user();
        $authId = $user->id;

        if ($user->alert_notification == '1') {
            $update_user = User::whereId($authId)->update(['alert_notification' => '0']);
            if ($update_user) {
                return $this->successResponse('Alert Notifications Disabled Successfully', 200);
            } else {
                return $this->errorResponse('Something went wrong.', 400);
            }
        } else if ($user->alert_notification == '0') {
            $update_user = User::whereId($authId)->update(['alert_notification' => '1']);
            if ($update_user) {
                return $this->successResponse('Alert Notifications Enabled Successfully', 200);
            } else {
                return $this->errorResponse('Something went wrong.', 400);
            }
        }
    }

    final public function preference()
    {
        $preferences = Preference::get();

        if (count($preferences) > 0) {
            return $this->successDataResponse('Preferences List.', $preferences, 200);
        } else {
            return $this->errorResponse('Preferences not found.', 400);
        }
    }

    // public function getMemberPreference(Request $request)
    // {
    //     // Validate the request
    //     $this->validate($request, [
    //         'offset' => 'required|numeric',
    //         'latitude' => 'required',
    //         'longitude' => 'required',
    //     ]);

    //     // Get the API key from configuration
    //     $apiKey = config('services.google.api_key');
    //     $url = "https://maps.googleapis.com/maps/api/geocode/json";
    //     $latitude = $request->latitude;
    //     $longitude = $request->longitude;

    //     // Make the API call to Google Geocoding API
    //     $response = Http::get($url, [
    //         'latlng' => "{$latitude},{$longitude}",
    //         'key' => $apiKey,
    //     ]);

    //     // Check if the response was successful
    //     if ($response->successful()) {
    //         $results = $response->json()['results'];

    //         // Iterate over the results to find the state
    //         foreach ($results as $result) {
    //             foreach ($result['address_components'] as $component) {
    //                 if (in_array('administrative_area_level_1', $component['types'])) {
    //                     // Query the members by state with pagination
    //                     $members = Member::where('currentMember', '1')->where('state', $component['long_name'])
    //                         ->skip($request->offset)
    //                         ->take(10)
    //                         ->get();

    //                     // Check if members were found
    //                     if (count($members) > 0) {
    //                         $data = MemberResource::collection($members);

    //                         return $this->successDataResponse('Preference found successfully.', $data, 200);
    //                     } else {
    //                         return $this->errorResponse('No preference found.', 400);
    //                     }
    //                 }
    //             }
    //         }
    //     }
    //     // Return null if something went wrong
    //     return $this->errorResponse('Unable to fetch state data.', 500);
    // }

    public function getMemberPreference(Request $request)
    {
        $this->validate($request, [
            'offset' => 'required|numeric',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
        ]);

        $latitude = $request->latitude;
        $longitude = $request->longitude;

        if ($latitude && $longitude) {
            $apiKey = config('services.google.api_key');
            $url = "https://maps.googleapis.com/maps/api/geocode/json";

            $response = Http::get($url, [
                'latlng' => "{$latitude},{$longitude}",
                'key' => $apiKey,
            ]);

            if ($response->successful()) {
                $results = $response->json()['results'];

                foreach ($results as $result) {
                    foreach ($result['address_components'] as $component) {
                        if (in_array('administrative_area_level_1', $component['types'])) {
                            $members = Member::where('currentMember', '1')
                                ->where('state', $component['long_name'])
                                ->skip($request->offset)
                                ->take(10)
                                ->get();

                            if (count($members) > 0) {
                                $data = MemberResource::collection($members);
                                return $this->successDataResponse('Preference found successfully.', $data, 200);
                            }

                            // If no members are found for the state, break out of loop to show random members
                            break 2;
                        }
                    }
                }
            }
        }

        $randomMembers = Member::where('currentMember', '1')
            ->inRandomOrder()
            ->skip($request->offset)
            ->take(10)
            ->get();

        if (count($randomMembers) > 0) {
            $data = MemberResource::collection($randomMembers);
            return $this->successDataResponse('Preference found successfully.', $data, 200);
        }

        return $this->errorResponse('No preference found.', 400);
    }


    public function userMemberPreference(Request $request)
    {
        $this->validate($request, [
            'offset' => 'required|numeric',
        ]);

        $user = auth()->user();
        $authId = $user->id;

        $user = User::where('id', $authId)->first(['id', 'member_preferences']);
        $preferences = json_decode($user->member_preferences, true);

        $members = Member::where('currentMember', '1')->whereIn('id', $preferences)
            ->skip($request->offset)
            ->take(10)
            ->get();

        if (count($members) > 0) {
            $data = MemberResource::collection($members);

            return $this->successDataResponse('User member Preference found successfully.', $data, 200);
        } else {
            return $this->errorResponse('No member preference found.', 400);
        }
    }

    public function getQoute()
    {
        $currentDate = Carbon::today()->format('Y-m-d');

        // Find today's quote
        $quote = Quote::where('date', $currentDate)->first();

        if ($quote) {
            return $this->successDataResponse("Quote found successfully", $quote, 200);
        } else {
            // If today's quote is not found, fetch the default quote
            $defaultQuote = Quote::where('status', '1')->first();

            if ($defaultQuote) {
                return $this->successDataResponse("Default quote retrieved", $defaultQuote, 200);
            } else {
                return $this->errorResponse("Quote not found", 400);
            }
        }
    }

    // My Right List
    public function myRight(Request $request)
    {
        $this->validate($request, [
            'offset' => 'required|numeric',
        ]);

        $authId = auth()->user()->id;
        $savedIds = SaveMyRight::where('user_id', $authId)->pluck('my_right_id')->toArray();

        $myrights = MyRight::skip($request->offset)
            ->take(10)
            ->get();

        $myrights = $myrights->map(function ($myright) use ($savedIds) {
            $myright->is_save = in_array($myright->id, $savedIds) ? 1 : 0;
            return $myright;
        });

        if (count($myrights) > 0) {
            return $this->successDataResponse('My Right member found successfully.', $myrights, 200);
        } else {
            return $this->errorResponse('No my Right found.', 400);
        }
    }

    public function myRightSaveRemove(Request $request)
    {
        $this->validate($request, [
            'my_right_id' => 'required|exists:my_rights,id',
        ]);

        $authId = auth()->user()->id;

        try {

            $saveExists = SaveMyRight::where(['user_id' => $authId, 'my_right_id' => $request->my_right_id])->first();

            if (!empty($saveExists)) {
                $saveExists->delete();
                return $this->successResponse('Removed my right.');
            } else {
                SaveMyRight::create([
                    'user_id' => $authId,
                    'my_right_id'   => $request->my_right_id
                ]);
                return $this->successResponse('Saved my right successfully.');
            }
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }

    public function myRightSaveList(Request $request)
    {
        $this->validate($request, [
            'offset' => 'required|numeric',
        ]);

        $authId = auth()->user()->id;

        $savedIds = SaveMyRight::where('user_id', $authId)->pluck('my_right_id');

        $myRight = MyRight::whereIn('id', $savedIds)->skip($request->offset)
            ->take(10)->get();
        if (count($myRight) > 0) {
            return $this->successDataResponse('Saved bill found successfully', $myRight, 200);
        } else {
            return $this->errorResponse('bill not found.', 400);
        }
    }

    public function aboutApp()
    {
        $about_app = Setting::first(['about_app', 'election_date']);
        return $this->successDataResponse('About found successfully', $about_app, 200);
    }

    public function whiteHouseDetail()
    {
        $whiteHouse =  WhiteHouseDetail::first();
        return $this->successDataResponse('White house detail found successfully', $whiteHouse, 200);
    }

    public function congressDetail()
    {
        $congressDetail =  CongressDetail::first();
        return $this->successDataResponse('Congress detail found successfully', $congressDetail, 200);
    }

    /** Help and feedback */
    public function helpAndFeedback(Request $request)
    {
        $this->validate($request, [
            'subject'          =>      'required',
            'description'      =>      'required'
        ]);
        $authId = auth()->user()->id;
        $images = array();

        if ($request->has('images')) {
            foreach ($request->images as $image) {
                $imageName = strtotime("now") . mt_rand(100000, 900000) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('/media/help_and_feedback'), $imageName);
                array_push($images, '/media/help_and_feedback/' . $imageName);
            }
        }

        $feedback = HelpAndFeedBack::create([
            'user_id'       =>  $authId,
            'subject'       =>  $request->subject,
            'description'   =>  $request->description,
            'images'        =>  json_encode($images)
        ]);

        return $this->successResponse('Feedback has been submit successfully.');
    }

    public function nationalDebts(Request $request)
    {
        $this->validate($request, [
            'year'          =>      'required',
        ]);

        $year = $request->year;

        $nationalDebt = nationalDebt::whereYear('record_date', $year)->first();

        if ($nationalDebt) {
            return $this->successDataResponse('National debt found successfully', $nationalDebt, 200);
        } else {
            return $this->errorResponse('National debt not found.', 400);
        }
    }

    // Get Budget Function
    public function getBudgetFunction(Request $request)
    {
        try {
            $year = $request->year;

            $budgetFunctions = BudgetFunction::where('year', $year)
                ->orderBy('amount', 'desc')
                ->get();

            if ($budgetFunctions->isEmpty()) {
                return $this->errorResponse('No budget functions found for the specified year.', 404);
            }

            $totalAmount = $budgetFunctions->sum('amount');

            $topBudgetFunctions = $budgetFunctions->take(4);

            $othersAmount = $budgetFunctions->skip(4)->sum('amount');

            $topBudgetFunctionsWithPercentage = $topBudgetFunctions->map(function ($budgetFunction) use ($totalAmount) {
                $percentage = $totalAmount > 0 ? number_format(($budgetFunction->amount / $totalAmount) * 100, 2) : 0;
                $amount = number_format($budgetFunction->amount, 2);
                return [
                    'name' => $budgetFunction->name,
                    'amount' => $amount,
                    'percentage' => $percentage
                ];
            });

            if ($othersAmount > 0) {
                $othersPercentage = $totalAmount > 0 ? number_format(($othersAmount / $totalAmount) * 100, 2) : 0;
                $othersAmountFormatted = number_format($othersAmount, 2);
                $topBudgetFunctionsWithPercentage->push([
                    'name' => 'Others',
                    'amount' => $othersAmountFormatted,
                    'percentage' => $othersPercentage
                ]);
            }

            $data = [
                'total_amount' => number_format($totalAmount, 2),
                'budget_functions' => $topBudgetFunctionsWithPercentage
            ];

            return $this->successDataResponse('Budget functions found successfully for year ' . $year, $data, 200);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }

    // Get House Representative Detail
    public function houseRepresentativeDetail()
    {
        $houseDetail =  HouseDetail::first();
        return $this->successDataResponse('House detail found successfully', $houseDetail, 200);
    }

    // Get Senate Detail
    public function senateDetail()
    {
        $senateDetail =  SenateDetail::first();
        return $this->successDataResponse('Senate detail found successfully', $senateDetail, 200);
    }

    // Bill Of Right Detail
    public function billOfRightDetail()
    {
        $billOfRight =  BillOfRight::first();
        return $this->successDataResponse('Bill of right detail found successfully', $billOfRight, 200);
    }
}
