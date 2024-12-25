<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Notification\Send;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function index()
    {
        return view("admin.notification.index");
    }

    /***********************  Admin Send  Notification  *********************/
    public function sendNotification(Send $request)
    {

        try {

            $users = User::get(['id', 'device_token', 'push_notification', 'alert_notification']);

            foreach ($users as $user) {

                $notification = [
                    'device_token' => $user->device_token,
                    'receiver_id' => $user->id,
                    'full_name' => "Admin",
                    'title'  => $request->title,
                    'description' => $request->description,
                    'record_id' => 1,
                    'type' => "admin_to_all",
                ];

                if ($user->device_token != null && $user->push_notification == '1') {
                    Helper::push_notification($notification);
                }
                if ($user->alert_notification == '1') {
                    Helper::in_app_notification($notification);
                }
            }
            return response()->json(["success" => "Notification Send Successfully"]);
        } catch (\Exception $e) {
            Log::error('Error notification: ' . $e->getMessage());
        }
    }
}
