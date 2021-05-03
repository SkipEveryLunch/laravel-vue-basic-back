<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function index()
    {
        \Gate::authorize("view","users");
        return UserResource::collection(User::with("role")->paginate());
    }

    public function store(UserCreateRequest $req)
    {
        $user = User::create(
            $req->only("first_name",
                    "last_name",
                    "email",
                    "role_id")+
                    ["password"=>\Hash::make("111111")]);
        return response(new UserResource($user),Response::HTTP_CREATED);
    }


    public function show($id)
    {
        \Gate::authorize("view","users");
        $user = User::with("role")->find($id);
        return new UserResource($user);
    }

    
    public function update(UserUpdateRequest $req, $id)
    {
        \Gate::authorize("edit","users");
        $user = User::find($id);
        $user->update(
            $req->only("first_name",
                    "last_name",
                    "email",
                    "role_id")
        );
        return response(new UserResource($user),Response::HTTP_ACCEPTED);
    }

    
    public function destroy($id)
    {
        \Gate::authorize("edit","users");
        User::destroy($id);
        return response(null,Response::HTTP_NO_CONTENT);
    }
}
