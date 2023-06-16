<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    //

    public function packageAdd(Request $request){
        logger($request);
    }
}