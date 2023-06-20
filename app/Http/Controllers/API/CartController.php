<?php

namespace App\Http\Controllers\API;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    //

    public function add_Food_Package(Request $request){
        // logger($request->type['package_id']);

        DB::beginTransaction();
        try {
            $data = $this->DataCollect($request);
            $cart = Cart::create($data);
            // logger($data);

            // logger($cart);
            DB::commit();
            return $cart ;
        } catch (\Throwable $th) {
            //throw $th;
            logger($th);

            DB::rollback();
        }

    }


    public function user_cart_List($id){


        $cartList = Cart::select('food_id','package_id' , DB::raw('COUNT(*) as count'))
        ->with(['food','package.food'])
        ->groupBy('food_id','package_id')
        ->where('user_id', $id)
                        ->get();

        return $cartList;

    }





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