<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        return view("admin.setting.index", compact("setting"));
    }
    public function update(Request $request)
    {
        $setting = Setting::find($request->id);
        $setting->company_name = $request->company_name;
        $setting->about_app = $request->about_app;
        $setting->election_date = $request->election_date;
        $setting->update();
        return response()->json(["success" => "Setting Updated successfully"]);
    }
}
