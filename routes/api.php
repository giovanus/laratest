<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::post('auth/register',[UserController::class,'register']);
Route::post('auth/login',[UserController::class,'login']);
Route::get('auth/logout',[UserController::class,'logout'])->middleware(['auth:sanctum']);
Route::get('hello',[UserController::class,'sayHello'])->middleware(['auth:sanctum']);
