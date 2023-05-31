<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Food;
use App\Models\FoodTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class FoodController extends Controller
{



    // Specific & ALL

    public function getSpecific($id){

        if($id == 'All'){
            // $data = Food::all();
            $data = Food::with( ['tag','category'] )->get();
        }else{
            $data = Food::with('tag')->where('category_id',$id)->get();
        }

        return response()->json($data, 200);
    }




    // Create FOOD from frontend =====================================================================

    public function foodCreate(Request $request){

        Log::info($request);
        $tags = $request->tags;
        $foodTags = [];


    $this->validation($request);

    DB::beginTransaction();
    try {
        $food =  Food::create([
            'name' => $request->name,
            'price' =>$request->price,
            'status' => 1,
            'description' =>$request->description,
            'category_id' =>$request->category_id,
            'image' =>$request->image,
            'type' =>$request->type = $request->type == 'Meal' ? 1: 0,
            'created_at' => Carbon::now()
        ]);

        foreach ($tags as $tag) {

            array_push($foodTags,['tag_id'=> $tag, 'food_id'=> $food->id, 'created_at' => Carbon::now(), 'updated_at'=> Carbon::now()]);
        }

        FoodTag::insert($foodTags);
        DB::commit();


    } catch (\Throwable $th) {

        DB::rollback();
    }
        // foreach ($tags as $tag) {
        //     FoodTag::create([
        //         'tag_id' => $tag,
        //         'food_id' =>$food->id
        //     ]);
        // }


    }

    //  EDIT FIELD (Food)

    public function foodBySpecific($id){

        $food = Food::where('id', $id)->with(['tag','category'])->first();
        return response()->json($food, 200);

    }

    //  UPDATE (Food) ============================

    public function foodUpdate(Request $request){

        // logger($request);

        // tag is old value ----
        // tags is new value ====



        $this->validation($request);

        try{
        $Del_food_tag =  FoodTag::where('food_id', $request->id)->delete();
        $tags = $request->tags;
        $foodTags =[];

        $food = Food::find($request->id);

        $food->update([
            'name' => $request->name,
            'price' =>$request->price,
            'status' => 1,
            'description' =>$request->description,
            'category_id' =>$request->category_id,
            'image' =>$request->image,
            'type' =>$request->type = $request->type == 'Meal' ? 1: 0,
            'created_at' => Carbon::now()
        ]);

        foreach ($tags as $tag){
            array_push($foodTags,['tag_id'=>$tag, 'food_id'=>$food->id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now() ]);
        }

        FoodTag::insert($foodTags);
        DB::commit();

        }catch(\Throwable $th){

            DB::rollback();


        }




    }





    // ===================================
    // VALIDATION
    // ===================================

    private function validation(Request $request){

       $rules = [
        'name' => 'required|unique:food,name,'.$request->id,
        'price' => 'required|numeric|min:1',
        'type' => 'required|',
        'description' => 'required',
        'category_id' => 'required',
        'image' => 'required|url',
        'tags' => 'required',
       ];

       Validator::make($request->all(),$rules)->validate();

    }



}