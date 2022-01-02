<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        return response()->json(User::all());
    }

    public function createUser(Request $request){
        $request->validate([
            'email'    => 'bail|required|email|unique:users',
            'password' => 'bail|required|max:8|min:4',
            'userName' => 'required',
            'userType' => 'required'
        ]);

        User::create([
            'fullname' => $request->userName,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'userType' => $request->userType,
        ]);
    }
}
