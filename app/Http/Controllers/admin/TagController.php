<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{

    public function storeTag(){
        return response()->json(['msg' => 'this is your response']);
    }
//
//    public function Test(){
//        return response()->json([
//            "msg" => "some error occed"
//        ], 422);
//    }

    public function addTag(Request $request){

        $request->validate([
            'tagName' => 'required'
        ]);

        Tag::create([
            'tagsName' =>$request->tagName
        ]);

    }
    public function editTag(Request $request){
        $request->validate([
            'tagsName' => 'required',
            'id' => 'required'
        ]);

        Tag::where('id', $request->id)->update([
            'tagsName' =>$request->tagsName
        ]);
    }

    public function allTag(){
        return $tags = Tag::orderBy('id', 'desc')->get();
    }

    public function deleteTag(Request $request){
        Tag::where('id', $request->id)->delete();
    }






}
