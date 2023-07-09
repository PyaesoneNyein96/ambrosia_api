<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Food;
use App\Models\FoodTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class FoodController extends Controller
{



    // Specific & ALL Show

    public function getSpecific($id){

        if($id == 'All'){
            $data = Food::with( ['tag','category'] )->orderBy('created_at','desc')->get();
        }else{
            $data = Food::with('tag')->where('category_id',$id)->orderBy('created_at','desc')->get();
        }

        return response()->json($data, 200);
    }

    // Get Food by Type (Drink or Food)

    public function getFoodByType($type){

        if($type == 1){
        return   $food = Food::with(['tag','category'])->where('type', 1)->orderBy('created_at','desc')->get();
        }else if
        ($type == 0){
            return $food = Food::with(['tag','category'])->where('type', 0)->orderBy('created_at','desc')->get();
        }else{
            return $food = Food::with(['tag','category'])->orderBy('created_at','desc')->get();
        }


    }


    // Create FOOD from frontend =====================================================================

    public function foodCreate(Request $request){

        // Log::info($request);
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
            'excerpt' =>$request->excerpt,
            'category_id' =>$request->category_id,
            'image' =>$request->image,
            'type' =>$request->type = $request->type,
            'created_at' => Carbon::now()
        ]);

        foreach ($tags as $tag) {

            array_push($foodTags,['tag_id'=> $tag, 'food_id'=> $food->id, 'created_at' => Carbon::now(), 'updated_at'=> Carbon::now()]);
        }

        FoodTag::insert($foodTags);
        DB::commit();

        return response()->json([
            'food' => $food
        ], 200, );

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

        // Validation
        $this->validation($request);
        DB::beginTransaction();
        try{

        // Clear Old Tags
        $Del_food_tag =  FoodTag::where('food_id', $request->id)->delete();

        // Assign New Tags in Array
        $tags = $request->tags;
        $foodTags =[];

        // Find specific data item
        $food = Food::find($request->id);

        // Data Collect
        $data = $this->dataCollector($request);
        // Update
        $food->update($data);

        // Re-Fetch record item
        $re_food = Food::find($food->id);

        // Adding Tags to Pivot table with Looping
        foreach ($tags as $tag){
            array_push($foodTags,['tag_id'=>$tag, 'food_id'=>$food->id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now() ]);
        }

        // pivot table Create
        FoodTag::insert($foodTags);
        DB::commit();
        return response()->json([
            'food' => $re_food
        ], 200, );


        }catch(\Throwable $th){

            DB::rollback();


        }

    }

        // ===========================================
        // foodDelete
        // ===========================================

        public function foodDelete($id){
        $food = Food::find($id);
        $food->delete();

            return response()->json([
                'food' => $food
            ], 200);
        }



        // ===========================================
        // Special Menu for User
        // ===========================================

        public function specialMenu(Request $request){
            logger($request);
            $result = Tag::with('food')->where('name','Special')->get();
            return $result[0]->food;
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
        'excerpt' => 'required|min:20',
        'category_id' => 'required',
        'image' => 'required|url',
        'tags' => 'required',
       ];

       Validator::make($request->all(),$rules)->validate();

    }

    // ===================================
    // Data Collecting For Update
    // ===================================

    private function dataCollector(Request $request){
        return [
            'name' => $request->name,
            'price' =>$request->price,
            'status' => 1,
            'description' =>$request->description,
            'excerpt' => $request->excerpt,
            'category_id' =>$request->category_id,
            'image' =>$request->image,
            'type' =>$request->type = $request->type,
            'created_at' => Carbon::now()
        ];
    }


}