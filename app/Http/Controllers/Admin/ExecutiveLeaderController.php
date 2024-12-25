<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExecutiveLeader;
use App\Http\Requests\Executive\Add;
use App\Http\Requests\Executive\Update;

class ExecutiveLeaderController extends Controller
{
    final public function  view()
    {
        return view("admin.executive.view");
    }

    public function read()
    {
        $executive_leader = ExecutiveLeader::orderBy('id', 'DESC')->get();
        return view("admin.executive.read", compact("executive_leader"));
    }

    final public function create()
    {
        return view("admin.executive.create");
    }

    final public function save(Add $request)
    {
        ExecutiveLeader::create($request->all());

        return response()->json(["success" => "Executive Leader Save Successfully"]);
    }

    final public function edit(Request $request)
    {
        $id = $request->id;
        $executive = ExecutiveLeader::find($id);
        return view('admin.executive.update', compact('executive'));
    }
    final public function update(Update $request)
    {
        $data = $request->except('id');
        ExecutiveLeader::where('id', $request->id)->update($data);
        return response()->json(["success" => "Executive Leader updated successfully"]);
    }
    public function delete($id)
    {
        $executiveLeader = ExecutiveLeader::find($id);
        $executiveLeader->delete();
        return response()->json(["success" => "Executive Leader Deleted successfully"]);
    }
}
