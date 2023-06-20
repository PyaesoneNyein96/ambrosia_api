<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TagController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\FoodController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\SearchController;
use App\Http\Controllers\API\PackageController;
use App\Http\Controllers\API\CategoryController;



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('user/login', [AuthController::class,'login']);
Route::post('user/register',[AuthController::class,'register']);
Route::post('user/autoLogin',[AuthController::class,'autoLogin']);






//  Customers
Route::get('user/menu/getSpecific/{id}',[FoodController::class,'getSpecific']);
Route::post('user/profile/update',[UserController::class,'updateProfile']);
Route::get('user/special/menu',[FoodController::class,'specialMenu']);

// Food manage (Admin)
Route::post('food/create',[FoodController::class,'foodCreate']);
Route::get('food/edit/{id}',[FoodController::class,'foodBySpecific']); //For Edit Page
Route::post('food/update',[FoodController::class,'foodUpdate']);
Route::post('food/delete/{id}',[FoodController::class,'foodDelete']);
Route::get('food/type/{id}',[FoodController::class,'getFoodByType']);


// Search (Admin)
Route::post('search/food',[SearchController::class,'searchFoodByAdmin']);
Route::post('search/user',[SearchController::class,'searchUserByAdmin']);


// Categories manage (Admin)
Route::get('user/categoriesList',[CategoryController::class,'list']);
Route::post('category/create',[CategoryController::class,'create']);
Route::post('category/update',[CategoryController::class,'update']);
Route::post('category/delete/{id}',[CategoryController::class,'delete']);

// Tags manage (Admin)
Route::get('user/tagsList',[TagController::class,'list']);
Route::post('tag/add', [TagController::class,'create']);
Route::post('tag/edit', [TagController::class,'edit']);
Route::post('tag/delete/{id}', [TagController::class,'delete']);


// User manage (Admin)
Route::get('user/list',[UserController::class,'list']);
Route::post('user/update',[UserController::class,'update']);
Route::post('user/delete/{id}',[UserController::class,'delete']);
Route::post('user/role/{id}',[UserController::class,'getUserByRole']);


// Package (Admin)
Route::post('package/add',[PackageController::class,'packageAdd']);
Route::get('package/list',[PackageController::class,'packageList']);
Route::post('package/update',[PackageController::class,'packageUpdate']);
Route::post('package/delete/{id}',[PackageController::class,'packageDelete']);


// Cart (User)

Route::post('user/cart',[CartController::class,'add_Food_Package']);
Route::post('user/cart/list/{id}',[CartController::class,'user_cart_List']);

// ->middleware('auth:sanctum')
;