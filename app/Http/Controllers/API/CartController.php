<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    // Add and Create Cart by User
    public function add_Food_Package(Request $request){


        DB::beginTransaction();
        try {
            $data = $this->DataCollect($request);
            $cart = Cart::create($data);

            DB::commit();
            return $cart ;
        } catch (\Throwable $th) {
            //throw $th;
            logger($th);

            DB::rollback();
        }

    }


    // Cart List By (Count)
    public function user_cart_List($id){

        $cartList = Cart::select('food_id','package_id' , DB::raw('COUNT(*) as count'))
        ->with(['food','package.food'])
        ->groupBy('food_id','package_id')
        ->where('user_id', $id)
                        ->get();

        return $cartList;

    }

// Cart remove
    public function cart_remove(Request $request){

        if(isset($request->food_id)){
            $food = Cart::where('food_id', $request->food_id)->delete();
        }else if(isset($request->package_id))
        {
            $food = Cart::where('package_id', $request->package_id)->delete();

        }

    }






    // public function cart_modify_add(Request $request){

    //     if($request->package_id){
    //         $cartItem = Cart::where('package_id', $request->package_id)->first();
    //         $addItem = $cartItem->replicate();
    //         $addItem->created_at = Carbon::now();
    //         $addItem->save();

    //     }else if($request->food_id){
    //         logger('f');

    //     }

    // }





//  ============================
//  Data Collect
//  ============================

        private function DataCollect($request){
           if(isset($request->type['food_id'])){
            return [
                'user_id' => $request->user_id,
                'food_id' => $request->type['food_id'],
                'package_id' => null,
            ];
           } else if(isset($request->type['package_id'])){
            return [
                'user_id' => $request->user_id,
                'food_id' => null,
                'package_id' => $request->type['package_id'],
            ];
           }
        }



}

// private function collect(){
//     return
//          $posts = ActionLog::select(
//             'action_logs.*','posts.*',
//             'categories.title as category_name', 'users.name as user_name',
//              DB::raw('COUNT(action_logs.post_id) as post_count')
//          )

//         ->leftJoin('posts','posts.id','action_logs.post_id')
//         ->leftJoin('categories','categories.id','posts.category_id')
//         ->leftJoin('users','users.id','posts.user_id')
//         ->groupBy('action_logs.post_id')

//         ->orderBy('post_count','desc')
//         ->get();
// }






// $cartList = Cart::select('food_id','package_id' , DB::raw('COUNT(*) as count'))
// ->where('user_id', $id)
// ->with(['food','package.food'])
// ->groupBy('food_id','package_id')
// ->get();