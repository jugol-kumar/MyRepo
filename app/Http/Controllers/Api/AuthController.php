<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except("login");
    }

    public function login(Request $request){
        $credintials = $request->only("email", "password");
        if (!$token = JWTAuth::attempt($credintials)){
            return response()->json(["success"=> false], 401);
        }
        return response()->json(["success"=>true, "token"=>$token], 200);
    }

    public function checkToken(Request $request){
        return response()->json(["success"=>true],  200);
    }

    public function logout(){
        $logout = auth()->logout();
        return response()->json(["success"=>true], 200);
    }

}
