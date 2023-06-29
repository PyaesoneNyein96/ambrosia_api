<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Food;
use App\Models\User;
use App\Models\Order;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Models\OrderOperation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    //

    public function add_order(Request $request){

        logger($request);
        DB::beginTransaction();
        try {

        $orderOperation =[];
        $order_total = 0;

        foreach ($request->toArray() as $item) {
            array_push($orderOperation, [
                'order_code' => $item['order_code'],
                'user_id' => $item['user_id'],
                'items_id' => $item['item_id'],
                'items_type' => $item['type'],
                'quantity' => $item['quantity'],
                'total' => $item['total'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            $order_total += $item['total'];
        }


       $percentage = $this->discountMath($orderOperation[0]['user_id']);

       $total = $order_total - ($order_total*$percentage);

        OrderOperation::insert($orderOperation);

        $order = Order::create([
            'user_id' => $orderOperation[0]['user_id'],
            'order_code' => $orderOperation[0]['order_code'],
            'total' => $total,
            'sub_total' => $order_total,
            'status' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        Cart::where('user_id',$order->user_id)->delete();
        DB::commit();

        return response()->json(200);

        } catch (\Throwable $th) {
            logger($th);

            DB::rollback();
            return response()->json(500);
        }

    }



    public function user_order_list($id){

        $userOrder = Order::where('user_id',$id)->orderBy('created_at', 'desc')->get();
        if($userOrder){
            return $userOrder;
        }else{
            return 500;
        }

    }


    // Admin Order List ==========================

    public function admin_order_list(){

        $adminOrders = Order::with('user')->orderBy('created_at', 'desc')->take(20)->get();
        return $adminOrders;
    }

// Admin Order Update ============================

    public function admin_order_list_update(Request $request){

        Order::where('id',$request->id)->update(['status' => $request->status]);

        return 200;

    }

    // Admin Order Detail ============================

    public function admin_order_Detail($code){



        // $orderOperation = OrderOperation::with(['food','packages'])->where('order_code',$code)->get();

        $orderOperation = orderOperation::with('items')->where('order_code',$code)->get();
        $mainOrder = Order::with('user.tag')->where('order_code',$code)->first();


        $coll = [];

        foreach ($orderOperation as $order) {
            array_push($coll,[
                'type' => $order->items_type,
                'quantity' => $order->quantity,
                'this_total' => $order->total,
                'name' => $order->items->name,
                'package_price' => $order->items->net_total,
                'food_price' => $order->items->price,
                'date' => $order->created_at,
                ]);
        }

        // logger($coll);

        $order_user = [
            'name' =>$mainOrder->user->name,
            'email' =>$mainOrder->user->email,
            'phone' =>$mainOrder->user->phone,
            'address' =>$mainOrder->user->address,
            'birthday' =>Carbon::parse($mainOrder->user->birthday),
            'restrictions'=> $mainOrder->user->restrictions,
            'allergies'=> $mainOrder->user->allergies,
            'preferred_cuisine' =>$mainOrder->user->tag ? $mainOrder->user->tag->name : null,
            'membership' => $mainOrder->membership,

            'order_id' => $mainOrder->id,
            'order_sub_total' => $mainOrder->sub_total,
            'order_total' => $mainOrder->total,
            'order_status' => $mainOrder->status,
            'order_code' => $mainOrder->order_code,
            'date' => $mainOrder->created_at,
        ];

        // logger($order_user->birthday);
        logger($order_user['date']);
        logger($order_user['birthday']);

        return [ 'orderUser' => $order_user,'all_items'=> $coll];



        // $all =[];

        // foreach ($orderOperation as $key) {
        //     if($key->items_type == 'App\models\Food') {
        //         $food = Food::where('id', $key['items_id'])->get();
        //         foreach($food as $f){
        //         array_push($all,
        //         ['food_name' => $f->name,
        //         'food_price' => $f->price,
        //         'food_img' => $f->image,
        //         'qty' => $key->quantity,
        //         'total'=>$key->total,
        //         ]);

        //         }
        //     }else if($key->items_type == 'App\models\Package'){
        //         $pack = Package::where('id', $key['items_id'])->get();
        //         foreach($pack as $p){
        //             array_push($all,
        //             [
        //              'pack_name' => $p->name,
        //              'pack_sub' => $p->sub_total,
        //              'pack_net' => $p->net_total,
        //              'qty' => $key->quantity,
        //              'total'=>$key->total,
        //             ]);
        //         }
        //     }
        // }

        // logger($all);

        // $final = array_merge($all,$mainOrder->toArray());  // Important to->Array()

        // return response()->json([
        //     'items' => $coll,
        //     'order_user' => $mainOrder
        // ], 200);

    }



    // ============ Admin Order get by Type ==============

    public function admin_order_Filter($id){

        if($id == 0){
            return  Order::with('user')->get();
        }else{
          return Order::with('user')->where('status' ,$id)->get();
        }



    }


    // ======= Private ===========

    private function discountMath($request){

        $user = User::find($request);

        if($user->membership == 1){
            return 5/100;
        }
        else if($user->membership == 2){
            return 10/100;
        }
        else if($user->membership == 3){
            return 15/100;
        }


    }



}



   // Admin Order Detail ============================

//    public function admin_order_Detail($code){

//     $orderOperation = OrderOperation::with(['food','packages'])->where('order_code',$code)->get();
//     $mainOrder = Order::with('user')->where('order_code',$code)->first();

//     $all =[];

//     foreach ($orderOperation as $key) {
//         if($key->items_type == 'App\models\Food') {
//             $food = Food::where('id', $key['items_id'])->get();
//             foreach($food as $f){
//             array_push($all,
//             ['food_name' => $f->name,
//             'food_price' => $f->price,
//             'food_img' => $f->image,
//             'qty' => $key->quantity,
//             'total'=>$key->total,
//             ]);

//             }
//         }else if($key->items_type == 'App\models\Package'){
//             $pack = Package::where('id', $key['items_id'])->get();
//             foreach($pack as $p){
//                 array_push($all,
//                 [
//                  'pack_name' => $p->name,
//                  'pack_sub' => $p->sub_total,
//                  'pack_net' => $p->net_total,
//                  'qty' => $key->quantity,
//                  'total'=>$key->total,
//                 ]);
//             }
//         }
//     }

//     logger($all);

//     $final = array_merge($all,$mainOrder->toArray());  // Important to->Array()

//     return response()->json([
//         'items' => $all,
//         'order_user' => $mainOrder
//     ], 200);

// }
