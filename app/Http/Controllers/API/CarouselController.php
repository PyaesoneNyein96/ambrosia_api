<?php

namespace App\Http\Controllers\API;

use App\Models\Carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CarouselController extends Controller
{

    //List
    public function getCarousels(){

         return Carousel::orderBy('created_at','desc')->get();

    }

    //Add
    public function addCarousel(Request $request){


        DB::beginTransaction();
       try {
        Carousel::create($this->collData($request));

        DB::commit();
        return 200;
       } catch (\Throwable $th) {
        logger($th);
       }


    }


    //Delete
    public function deleteCarousel($id){
        Carousel::find($id)->delete();
        return 200;

    }

    public function updateCarousel(Request $request){


        DB::beginTransaction();

        try {
            $carousel = Carousel::find($request->id);

            $data = $this->collData($request);

            $carousel->update($data);

            DB::commit();

            return 200;
        } catch (\Throwable $th) {
            logger($th);
        }



    }










    private function collData($request){
        return [
            'image' => $request->image,
            'title' => $request->title,
            'title_color' => $request->title_color,
            'description' => $request->description,
            'position' => $request->position,
            'color' => $request->color,
        ];
    }
}