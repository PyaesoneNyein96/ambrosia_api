<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    // Show All

    public function list(){

        $data = Category::orderBy('created_at','desc')->get();

        return response()->json($data, 200);
    }


    // Create

    public function create(Request $request){

        Validator::make($request->all(),
         ['name' => 'required|unique:categories,name,'.$request->id]
         )->validate();

        $category = Category::create(['name' => $request->name]);

        return response()->json([
            'category' => $category
        ], 200);
    }


    public function update(Request $request){

        validator::make($request->all(), ['name' => 'required|unique:categories,name,'.$request->id])->validate();

        $category = Category::find($request->id)->update(['name' => $request->name]);
        $categoryUpdated = Category::find($request->id);

        return response()->json([
            'category' => $categoryUpdated
        ], 200);

    }

    public function delete($id){

        $category = Category::find($id);
        $category->delete();

        return response()->json([
            'category' => $category
        ], 200);

    }


}