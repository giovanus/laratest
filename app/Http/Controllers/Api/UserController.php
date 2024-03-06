<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {

       $validator = Validator::make($request->all(),[
        "username"=> "string",
        "email"=>"required|email|unique:users",
        "password"=>"required|string|min:8",
       ]);

       if($validator->fails()){
        return response()->json([
            'status'=>400,
            'errors'=>$validator->errors()
           ],400);
       }

       $user = User::create([
        "username"=> $request->username,
        "email"=>$request->email,
        "password"=>Hash::make($request->password),
       ]);

       $token = $user->createToken('token')->plainTextToken;

       return response()->json([
        'status'=>201,
        'user'=>$user,
        'access_token'=>$token
       ],201);
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            "email"=>"required|string",
            "password"=>"required|string",
           ]);

           if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->errors()->first()
               ],400);
           }
        
        $credentials =request(['email','password']);
        if(!Auth::attempt($credentials)){
            return response()->json([
                'status'=>401,
                'message'=>' these credentials doesn\'t match our records'
            ],401);
        }
        
        $user = $request->user();
        $token = $user->createToken('token')->plainTextToken;
        return response()->json([
            'status'=>200,
            'user'=>$user,
            'access_token'=>$token
        ]);

    }

    public function sayHello(){
        return response()->json(['message'=>'hello world']);
    }
   


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([]);
    }
}
