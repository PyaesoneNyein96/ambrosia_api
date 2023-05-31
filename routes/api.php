<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TagController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\FoodController;
use App\Http\Controllers\API\CategoryController;



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('user/login', [AuthController::class,'login']);
Route::post('user/register',[AuthController::class,'register']);
Route::post('user/autoLogin',[AuthController::class,'autoLogin']);

Route::get('user/categoriesList',[CategoryController::class,'list']);
Route::get('user/tagsList',[TagController::class,'list']);



// USER MENU
Route::get('user/menu/getSpecific/{id}',[FoodController::class,'getSpecific']);

// FOOD create
Route::post('food/create',[FoodController::class,'foodCreate']);
Route::get('food/{id}',[FoodController::class,'foodBySpecific']); //For Edit
Route::post('food/update',[FoodController::class,'foodUpdate']);



// ->middleware('auth:sanctum')
;