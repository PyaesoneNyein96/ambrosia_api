<?php

namespace App\Http\Controllers\API;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    //

    public function list(){

        $tags = Tag::all();


        return response()->json($tags, 200);
    }
}