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
                'item_id' => $item['item_id'],
                'type' => $item['type'],
                'quantity' => $item['quantity'],
                'total' => $item['total'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
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


        $orderOperation = OrderOperation::with('user')->where('order_code',$code)->get();
        $mainOrder = Order::with('user')->where('order_code',$code)->get();
        // $order = $orderOperation[0]->order;
        // logger($orderOperation->toArray());
        $all =[];

        foreach ($orderOperation as $key) {
            if($key->type == 1) {
                $food = Food::where('id', $key['item_id'])->get();
                foreach($food as $f){
                array_push($all,
                ['food_name' => $f->name,
                'food_price' => $f->price,
                'food_img' => $f->image,
                'qty' => $key->quantity,
                'total'=>$key->total,
                ]);

                }
            }else if($key->type ==2){
                $pack = Package::where('id', $key['item_id'])->get();
                foreach($pack as $p){
                    array_push($all,
                    [
                     'pack_name' => $p->name,
                     'pack_sub' => $p->sub_total,
                     'pack_net' => $p->net_total,
                     'qty' => $key->quantity,
                     'total'=>$key->total,
                    ]);
                }
            }
        }
        // $final = array_merge($all,$mainOrder->toArray());  // Important to->Array()

        // logger($all);
        return response()->json([
            'items' => $all,
            'order_user' => $mainOrder
        ], 200);

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