<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MyRight;
use App\Http\Requests\MyRight\Add;
use App\Http\Requests\MyRight\Update;

class MyRightController extends Controller
{
    final public function  view()
    {
        return view("admin.my-right.view");
    }

    public function read()
    {
        $my_rights = MyRight::orderBy('id', 'DESC')->get();
        return view("admin.my-right.read", compact("my_rights"));
    }

    final public function create()
    {
        return view("admin.my-right.create");
    }

    final public function save(Add $request)
    {
        MyRight::create($request->all());

        return response()->json(["success" => "My Right Save Successfully"]);
    }

    final public function edit(Request $request)
    {
        $id = $request->id;
        $my_right = MyRight::find($id);
        return view('admin.my-right.update', compact('my_right'));
    }
    final public function update(Update $request)
    {
        $my_right = MyRight::findOrFail($request->id);
        $my_right->title = $request->title;
        $my_right->text_definition = $request->text_definition;
        $my_right->simplefied = $request->simplefied;
        $my_right->update();

        return response()->json(["success" => "My Right Updated successfully"]);
    }
    public function delete($id)
    {
        $my_right = MyRight::find($id);
        $my_right->delete();
        return response()->json(["success" => "My Right Deleted successfully"]);
    }
}
