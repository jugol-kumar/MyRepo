<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function allCategory(){
        $categoris = Category::get();
        return $categoris;
    }

    public function uploadImage(Request $request){

        $this->validate($request,[
            'file' => 'required|mimes:jpg,png,svg',
        ]);

        $imageName = time().".".$request->file->extension();
        $request->file->move(public_path('category'),$imageName);
        return $imageName;
    }

    public function deleteImage(Request $request){
        $imagename = $request->image;
        $filePath = public_path().'/category/'.$imagename;
        if (file_exists($filePath)){
            @unlink($filePath);
        }
        return "done";
    }

    public function addCategory(Request $request){
        $this->validate($request,[
           'category_name' => 'required|max:30',
           'iconImage' => 'required'
        ]);
        Category::create([
            'category_name'=> $request->category_name,
            'iconImage' => $request->iconImage
        ]);
    }

    public function updateCategory(Request $request){
        $category = Category::where('id', $request->id)->first();
        $category->update([
            'category_name'=> $request->category_name,
            'iconImage' => $request->iconImage
        ]);
    }


    public function deleteCategory(Request $request){
        $category = Category::where('id', $request->id)->first();
        $category->delete();
        return;
    }

}
