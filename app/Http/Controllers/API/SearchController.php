<?php

namespace App\Http\Controllers\API;

use App\Models\Food;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function searchFoodByAdmin(Request $request){

        $key = $request->key;

        $result = Food::with(['tag','category','user'])
        ->where('name','like',"%$key%")
        ->orWhere('price','like', "%$key%")
        ->orWhere('description','like', "%$key%")

        ->orWhereHas('tag', function($q) use($key){
            $q->where('name', 'like' ,"%$key%");
        })

        ->orWhereHas('category', function($q) use($key){
            $q->where('name', 'like', "%$key%");

        })
        // ->orWhereHas('user', function($q) use($key){
        //     $q->where('name', 'like', "%$key%")
        //     ->orWhere('email','like', "%$key%")
        //     ->orWhere('email','like', "%$key%")
        //     ->orWhere('phone','like', "%$key%")
        //     ->orWhere('address','like', "%$key%")
        //     ->orWhere('gender','like', "%$key%")
        //     ->orWhere('birthday','like', "%$key%");
        // })
        ->get();

        return response()->json([
            'result' => $result
        ], 200);
    }



    public function searchUserByAdmin(Request $request){

        $key= $request->key;

        $result = User::with('tag')
        ->where('name','like', "%$key%")
        ->orWhere('email','like', "%$key%")
        ->orWhere('address','like', "%$key%")
        ->orWhere('phone','like', "%$key%")
        ->orWhere('gender','like', "%$key%")
        ->orWhere('birthday','like', "%$key%")

        ->orWhereHas('tag', function($q) use($key){
            $q->where('name','like', "%$key%");
        })
        ->get();

        return response()->json([
            'result' => $result
        ], 200);

    }

    public function searchOrderByAdmin(Request $request){


        $pendingPattern = '/^pen(d(i(n(g)?)?)?)?$/';
        $confirmPattern = '/^con(f(i(r(m)?)?)?)?$/';
        $rejectPattern = '/^rej(e(c(t)?)?)?$/';

        $key = $request->key;

        if (preg_match($pendingPattern, $key)){
            $key = 1;
        }
        else if(preg_match($confirmPattern, $key)){
            $key = 2;
        }
        else if(preg_match($rejectPattern, $key)){
            $key = 3;
        }


        $result = Order::with('user')
        ->where('order_code', 'like', "%$key%")
        ->orWhere('total','like',"%$key%")
        ->orWhere('status','like',"%$key%")

        ->orWhereHas('user',function($q) use($key){
            $q->where('name','like', "%$key%")
            ->orWhere('email','like', "%$key%");
        })->get();

        return $result;
    }


}