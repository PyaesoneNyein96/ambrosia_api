<?php

namespace App\Http\Controllers\API;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\OrderOperation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    //

    public function add_order(Request $request){

        DB::beginTransaction();
        try {

        $orderOperation =[];
        $order_total = 0;

        foreach ($request->toArray() as $item) {
            array_push($orderOperation, [
                'order_code' => $item['order_code'],
                'user_id' => $item['user_id'],
                'item_id' => $item['item_id'],
                'type' => $item['type'],
                'quantity' => $item['quantity'],
                'total' => $item['total'],
            ]);
            $order_total += $item['total'];
        }


       $percentage = $this->discountMath($orderOperation[0]['user_id']);

       $order_total = $order_total - ($order_total*$percentage);

        OrderOperation::insert($orderOperation);

        $order = Order::create([
            'user_id' => $orderOperation[0]['user_id'],
            'order_code' => $orderOperation[0]['order_code'],
            'total' => $order_total,
            'status' => 1
        ]);

        Cart::where('user_id',$order->user_id)->delete();
        DB::commit();

        return response()->json(200);

        } catch (\Throwable $th) {
            logger($th);

            DB::rollback();
            return response()->json(500);
        }

        // $data = $this->dataCollect($request);
        // Order::create()

    }



    public function user_order_list($id){

        $userOrder = Order::where('user_id',$id)->get();
        if($userOrder){
            return $userOrder;
        }else{
            return 500;
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