<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Airline;
use Illuminate\Http\Request;

class AirlinesController extends Controller
{
    // get data
    public function index(Request $request){
        $airlines        = Airline::orderBy("id", "DESC")->paginate($request->total);
        return response()->json(["status" =>true, "data"=>$airlines], 200);
    }

    // store data
    public function store(Request $request){
        $request->validate([
            'name'    => 'required',
        ]);
        Airline::create([
            'name'        => $request->name,
            'description' => $request->details
        ]);
        return response()->json(["success"=>true], 200);
    }

    // update data
    public function update(Request $request){
        $airline         = Airline::findOrFail($request->id);
        $request->validate([
            'name'       => 'required',
        ]);
        $airline->update([
            'name'        => $request->name,
            'description' => $request->description
        ]);
        return response()->json(["success"=>true], 200);
    }

    //delete data
    public function delete(Request $request){
        $airline = Airline::findOrFail($request->id);
        $airline->delete();
        return response()->json(["success"=>true], 200);
    }
}
