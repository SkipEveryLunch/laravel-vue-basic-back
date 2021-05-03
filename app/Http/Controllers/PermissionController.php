<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use App\Http\Resources\PermissionResource;

class PermissionController extends Controller
{
    public function index(){
        $permissions = Permission::with("roles")->paginate();
        return PermissionResource::collection($permissions);
    }
}
