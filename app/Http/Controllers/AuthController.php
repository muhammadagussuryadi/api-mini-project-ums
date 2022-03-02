<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;

class AuthController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth('api')->attempt($validator->validated())) {
            return response()->json(['statusCode'=>401,'message' => 'Unauthorized'], 200);
        }
        return $this->createNewToken($token);
    }

    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }

    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    public function userProfile() {
        return response()->json(auth('api')->user());
    }

    protected function createNewToken($token){
        return response()->json(
            [
                "statusCode"=>200, 
                "message"=>"success",
                "data"=>[
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    // 'expires_in' => auth('api')->factory()->getTTL() * 120000000000,
                    'user' => auth('api')->user()
                ]
            ],200);
    }
}
