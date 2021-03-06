<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post("register",[AuthController::class,"register"]);
Route::post("login",[AuthController::class,"login"]);

Route::middleware('auth:sanctum')->group(
    function () {
        Route::get("user",[AuthController::class,"user"]);
        Route::delete("logout",[AuthController::class,"logout"]);
        Route::put("user/info",[AuthController::class,"updateInfo"]);
        Route::put("user/password",[AuthController::class,"updatePassword"]);

        Route::apiResource("users",UserController::class);
        Route::get("permissions",[PermissionController::class,"index"]);
        Route::apiResource("roles",RoleController::class);
        Route::apiResource("products",ProductController::class);
        Route::post("upload",[ImageController::class,"upload"]);

        Route::apiResource("orders",OrderController::class)->only("index","show");
        Route::get("items",[OrderController::class,"items"]);
        Route::get("export",[OrderController::class,"export"]);
        Route::get("chart",[OrderController::class,"chart"]);
});
