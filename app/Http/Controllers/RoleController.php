<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Role;
use App\Http\Resources\RoleResource;

class RoleController extends Controller
{
    public function index(){
        \Gate::authorize("view","roles");
        return RoleResource::collection(Role::all());
    }
    public function show($id){
        \Gate::authorize("view","roles");
        $role = Role::with("permissions")->find($id);
        return new RoleResource($role);
    }
    public function store(Request $req){
        \Gate::authorize("edit","roles");
        $role = Role::create(
            $req->only("name")
        );
        $role->permissions()->attach(
            $req->input("permissions")
        );
        return response(new RoleResource($role->load("permissions")),Response::HTTP_CREATED);
    }
    public function update(Request $req,$id){
        \Gate::authorize("edit","roles");
        $role = Role::find($id);
        $role->update(
            $req->only("name")
        );
        $role->permissions()->sync(
            $req->input("permissions")
        );
        return response(new RoleResource($role
        ->load("permissions")),Response::HTTP_ACCEPTED);
    }
    public function destroy($id){
        \Gate::authorize("edit","roles");
        Role::destroy($id);
        return response(null,Response::HTTP_NO_CONTENT);
    }
}
