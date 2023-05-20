<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('user/login', [AuthController::class,'login']);
Route::post('user/register',[AuthController::class,'register']);

Route::get('user/categories',[CategoryController::class,'list'])
->middleware('auth:sanctum')
;