<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quote;
use App\Http\Requests\Quote\Add;
use App\Http\Requests\Quote\Update;

class QuoteController extends Controller
{
    final public function  view()
    {
        return view("admin.quote.view");
    }
    public function read()
    {
        $quotes = Quote::orderBy('id', 'DESC')->get();
        return view("admin.quote.read", compact("quotes"));
    }
    final public function create()
    {
        return view("admin.quote.create");
    }
    final public function save(Add $request)
    {
        $quote = $request->only(
            'title',
            'date',
            'description',
        );

        // Handle image upload if an image file is provided
        if ($request->hasFile('image')) {
            $image = strtotime("now") . mt_rand(100000, 900000) . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('/quote/image'), $image);
            $file_path = '/quote/image/' . $image;
            $quote['image'] = $file_path;
        }

        // Check if this is the first quote, then set it as the default with status = 1
        $quote['status'] = Quote::exists() ? '0' : '1';

        // Create the quote
        Quote::create($quote);

        return response()->json(["success" => "Quote Save Successfully"]);
    }

    final public function edit(Request $request)
    {
        $id = $request->id;
        $quote = Quote::find($id);
        return view('admin.quote.update', compact('quote'));
    }
    final public function update(Update $request)
    {
        $quote = Quote::findOrFail($request->id);
        $quote->title = $request->title;
        $quote->date = $request->date;
        $quote->description = $request->description;

        if ($request->hasFile('image')) {
            $image = strtotime("now") . mt_rand(100000, 900000) . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('/quote/image'), $image);
            $file_path = '/quote/image/' . $image;
            $quote->image = $file_path;
        }

        $quote->update();

        return response()->json(["success" => "Quote Updated successfully"]);
    }
    public function delete($id)
    {
        $quote = Quote::find($id);
        $quote->delete();
        return response()->json(["success" => "Quote Deleted successfully"]);
    }

    public function default($id)
    {
        // Set all quotes' status to 0
        Quote::where('status', '1')->update(['status' => '0']);

        // Set the specific quote's status to 1 if it exists
        $quote = Quote::find($id);
        if ($quote) {
            $quote->status = '1';
            $quote->save();
        }

        return response()->json(["success" => "Quote default successfully"]);
    }
}
