<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateInfoRequest;
use App\Http\Requests\UpdatePasswordRequest;

class AuthController extends Controller
{
    public function register(RegisterRequest $req){
        $user = User::create([
            "first_name"=>$req->input("first_name"),
            "last_name"=>$req->input("last_name"),
            "email"=>$req->input("email"),
            "password"=>Hash::make($req->input("password")),
            "role_id"=>3
        ]);
        return response($user,Response::HTTP_CREATED);
    }
    public function login(Request $req){
        if(!Auth::attempt($req->only("email","password"))){
            return response([
                "error" => "invalid credentials"
            ],Response::HTTP_UNAUTHORIZED);
        }
        $user = Auth::user();
        $jwt = $user->createToken("token")->plainTextToken;
        $cookie = cookie(
            "jwt",$jwt,60 * 24
        );
        return response([
            "jwt"=>$jwt
        ])->withCookie($cookie);
    }
    public function user(Request $req){
        $user = $req->user();
        return $user->load("role");
    }
    public function logout(){
        $cookie = Cookie::forget("jwt");
        return response([
            "message" => "success"
        ])->withCookie($cookie);
    }
    public function updateInfo(UpdateInfoRequest $req){
        $user = $req->user();
        $user->update(
            $req->only("first_name",
                    "last_name",
                    "email")
        );
        return response($user,Response::HTTP_ACCEPTED);
    }
    public function updatePassword(UpdatePasswordRequest $req){
        $user = $req->user();
        $user->update([
            "password" => Hash::make($req->input("password"))
        ]);
        return response($user,Response::HTTP_ACCEPTED);
    }
}
