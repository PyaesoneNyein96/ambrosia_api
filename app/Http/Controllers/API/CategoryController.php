<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{

    public function list(){


        $categories = Category::get();

        return response()->json(['categories'=> $categories], 200);
    }

}