<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Package;
use App\Models\PackageFood;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PackageController extends Controller
{

    // (Create) Package with food =========================================

    public function packageAdd(Request $request){


        $selectedFood = [];
        // selected (only id) food id
        foreach ($request->selected as $s) {
            array_push($selectedFood, $s['id']);
        }

        $this->validationCheck($request);

        DB::beginTransaction();

        try {
            $data = $this->dataCollect($request);
            $data = Package::create($data);

            $packageFood = [];
            foreach ($selectedFood as $food_id) {

                array_push($packageFood,['food_id'=> $food_id,'package_id'=> $data->id,'created_at' => Carbon::now()]);
            }

            PackageFood::insert($packageFood);

            DB::commit();

            return response()->json([
                'package' => $data
            ], 200);

        } catch (\Throwable $th) {
            DB::rollback();
            logger($th);
        }

    }

     // Package (List) with food =========================================

    public function packageList(){

        return Package::with('food')->get();

    }


     // Package (Update) with food =========================================

    public function packageUpdate(Request $request){


        DB::beginTransaction();
        try {

            $package_id = Package::find($request->id);

            PackageFood::where('package_id',$request->id)->delete();

            $this->validationCheck($request);
            $data = $this->dataCollect($request);

            $selectedFood =[];

            foreach ($request->selected as $select) {
                array_push($selectedFood, $select['id']);
            }

            $package = Package::where('id', $request->id)->update($data);

            $updatePackage = Package::find($request->id);

            $Package_food =[];
            foreach ($selectedFood as $selected) {

                array_push($Package_food,['food_id' => $selected , 'package_id' => $updatePackage->id,'updated_at' => Carbon::now()], );

            }

            PackageFood::insert($Package_food);
            DB::commit();


            return response()->json([
                'package' => $updatePackage
            ], 200);


        } catch (\Throwable $th) {
            DB::rollback();
           logger($th);
        }


    }

     // Package (Delete) with food =========================================

     public function packageDelete($id){

        return $package = Package::find($id)->delete();

     }







    //===================================================
    // Private Helper
    //===================================================



    private function dataCollect($request){
            return[
                'name' => $request->name,
                'sub_total' => $request->sub_total,
                'net_total' => $request->net_total,
                'percentage' => $request->percentage,
            ];

    }

    private function validationCheck($request){


        Validator::make($request->all(), [
            'name' => 'required|unique:packages,name,'.$request->id,
            'sub_total' => 'required|numeric',
            'net_total' => 'required|numeric',
            'percentage' => 'required|numeric'
        ])->validate();

    }

}