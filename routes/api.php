<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TagController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\FoodController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\SearchController;
use App\Http\Controllers\API\PackageController;
use App\Http\Controllers\API\CarouselController;
use App\Http\Controllers\API\CategoryController;



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });





//  Customers *
Route::get('user/menu/getSpecific/{id}',[FoodController::class,'getSpecific']);
Route::post('user/profile/update',[UserController::class,'updateProfile']);
Route::get('user/special/menu',[FoodController::class,'specialMenu']);



Route::prefix('user')->group(function () {

    // Auth
    Route::post('login', [AuthController::class,'login']);
    Route::post('register',[AuthController::class,'register']);
    Route::post('autoLogin',[AuthController::class,'autoLogin']);

    // Cart (User)
    Route::post('cart',[CartController::class,'add_Food_Package']);
    Route::post('cart/list/{id}',[CartController::class,'user_cart_List']);
    Route::post('cart/remove',[CartController::class,'cart_remove']);

    //Cart to Order (CART => ORDER)
    Route::post('cart/order',[OrderController::class,'add_order']);
    Route::post('order/list/{id}',[OrderController::class,'user_order_list']);

    // Book Table with Cart
    Route::post('book/table',[OrderController::class,'book_table']);

    // Review
    Route::post('review/submit',[ReviewController::class,'submit_review']);
    Route::get('review/list', [ReviewController::class, 'review_list']);


    // password change
    Route::post('password/change',[AuthController::class,'passwordUpdate']);

});



// both (Admin & User)
Route::get('food/type/{id}',[FoodController::class,'getFoodByType']);




// Search (Admin)
Route::post('search/food',[SearchController::class,'searchFoodByAdmin']);
Route::post('search/user',[SearchController::class,'searchUserByAdmin']);
Route::post('search/order',[SearchController::class,'searchOrderByAdmin']);


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




Route::prefix('admin')->group(function () {

    // Food manage (Admin)
    Route::post('food/create',[FoodController::class,'foodCreate']);
    Route::get('food/edit/{id}',[FoodController::class,'foodBySpecific']); //For Edit Page
    Route::post('food/update',[FoodController::class,'foodUpdate']);
    Route::post('food/delete/{id}',[FoodController::class,'foodDelete']);

    // Order (admin)
    Route::get('order/list',[OrderController::class,'admin_order_list']);
    Route::post('order/update', [OrderController::class,'admin_order_list_update']);
    Route::post('order/detail/{code}', [OrderController::class,'admin_order_Detail']);
    Route::post('filter/order/{id}',[OrderController::class,'admin_order_Filter']);


    // Carousel (admin)
    Route::get('carousel/list', [CarouselController::class,'getCarousels']);
    Route::post('carousel/add', [CarouselController::class,'addCarousel']);
    Route::post('carousel/delete/{id}', [CarouselController::class,'deleteCarousel']);
    Route::post('carousel/update', [CarouselController::class,'updateCarousel']);
});

// ->middleware('auth:sanctum')
;