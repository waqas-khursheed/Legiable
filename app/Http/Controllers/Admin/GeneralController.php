<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Content,
    WhiteHouseDetail,
    CongressDetail,
    HelpAndFeedBack,
    HouseDetail,
    SenateDetail,
    BillOfRight
};

class GeneralController extends Controller
{
    public function contentEdit($type)
    {
        $content = Content::where('type', $type)->first();
        return view('admin.content.index', compact('content'));
    }
    public function contentUpdate(Request $request)
    {
        $content = Content::find($request->id);
        $content->content = $request->content;
        $content->update();
        return response()->json(["success" => "Content Updated successfully"]);
    }
    public function content($type)
    {
        $content = Content::where('type', $type)->first();
        return view('content.index', compact('content'));
    }

    // White House Detail
    public function whiteHouseDetail()
    {
        $white_house = WhiteHouseDetail::first();
        return view("admin.pages.white-house-detail", compact("white_house"));
    }

    // Update White House Detail
    public function updateWhiteHouseDetail(Request $request)
    {

        $whiteHouse = WhiteHouseDetail::find($request->id);
        $whiteHouse->title = $request->title;
        $whiteHouse->personal_detail = $request->personal_detail;
        $whiteHouse->additional_information = $request->additional_information;
        $whiteHouse->update();
        return response()->json(["success" => "White house detail updated successfully"]);
    }

    // Congress Detail
    public function congressDetail()
    {
        $congress = CongressDetail::first();
        return view("admin.pages.congress-detail", compact("congress"));
    }

    // Update Congress Detail
    public function updateCongressDetail(Request $request)
    {
        $congress = CongressDetail::find($request->id);
        $congress->title = $request->title;
        $congress->personal_detail = $request->personal_detail;
        $congress->additional_information = $request->additional_information;
        $congress->update();
        return response()->json(["success" => "Congress detail updated successfully"]);
    }

    public function helpAndFeedback()
    {
        $helpAndFeedbacks = HelpAndFeedBack::with('user')->latest()->get();
        return view('admin.help-and-feedback.index', compact('helpAndFeedbacks'));
    }

    // house Representative Detail
    public function houseRepresentativeDetail()
    {
        $house = HouseDetail::first();
        return view("admin.pages.house-representative-detail", compact("house"));
    }

    // update House Representative Detail
    public function updateHouseRepresentativeDetail(Request $request)
    {
        $house['title'] = $request->title;
        $house['additional_information'] = $request->additional_information;

        if ($request->hasFile('image')) {
            $image = strtotime("now") . mt_rand(100000, 900000) . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('/media/general'), $image);
            $file_path = '/media/general/' . $image;
            $house['image'] = $file_path;
        }
        HouseDetail::whereId($request->id)->update($house);
        return response()->json(["success" => "House detail updated successfully"]);
    }

    // senate Detail
    public function senateDetail()
    {
        $senate = SenateDetail::first();
        return view("admin.pages.senate-detail", compact("senate"));
    }

    // update Senate Detail
    public function updateSenateDetail(Request $request)
    {

        $senate['title'] = $request->title;
        $senate['additional_information'] = $request->additional_information;

        if ($request->hasFile('image')) {
            $image = strtotime("now") . mt_rand(100000, 900000) . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('/media/general'), $image);
            $file_path = '/media/general/' . $image;
            $senate['image'] = $file_path;
        }
        SenateDetail::whereId($request->id)->update($senate);
        return response()->json(["success" => "Senate detail updated successfully"]);
    }

    public function billOfRightDetail()
    {
        $bill_of_right = BillOfRight::first();
        return view("admin.pages.bill-of-right-detail", compact("bill_of_right"));
    }

    public function updateBillOfRightDetail(Request $request)
    {
        $bill_of_right = BillOfRight::find($request->id);
        $bill_of_right->title = $request->title;
        $bill_of_right->personal_detail = $request->personal_detail;
        $bill_of_right->additional_information = $request->additional_information;
        $bill_of_right->update();
        return response()->json(["success" => "Bill of right detail updated successfully"]);
    }
}
