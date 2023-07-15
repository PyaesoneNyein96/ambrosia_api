<?php

namespace App\Http\Controllers\API;

use App\Models\Tag;
// use App\Models\FoodTag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    //

    public function list(){

        $tags = Tag::with('food')->orderBy('created_at','desc')->get();
        // $tags = Tag::get();

        return response()->json($tags, 200);
    }

    // Create Tag
    public function create(Request $request){


        Validator::make($request->all(),
        ['name'=> 'required|unique:tags,name,'.$request->id])->validate();
        $tag = Tag::create(['name' => $request->name]);

        return response()->json([
            'tag' => $tag
        ], 200);

    }

    //Delete
    public function delete($id){

        $tag = Tag::find($id);
        $tag->delete();

        return response()->json([
            'tag' => $tag
        ], 200);

    }

    //edit & update
    public function edit(Request $request){

        Validator::make($request->all(),
        ['name'=> 'required|unique:tags,name,'.$request->id])->validate();

        $tag = Tag::find($request->id)->update(['name' => $request->name]);
        $tagUpdated =Tag::find($request->id);


        return response()->json([
            'tag' => $tagUpdated
        ], 200);

    }



}