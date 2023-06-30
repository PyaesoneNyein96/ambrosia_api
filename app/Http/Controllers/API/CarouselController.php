<?php

namespace App\Http\Controllers\API;

use App\Models\Carousel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CarouselController extends Controller
{

    //List
    public function getCarousels(){

         return Carousel::orderBy('created_at','desc')->get();

    }

    //Add
    public function addCarousel(Request $request){

        Carousel::create($this->collData($request));
        return 200;
    }


    //Delete
    public function deleteCarousel($id){
        logger($id);
        Carousel::find($id)->delete();
        return 200;

    }










    private function collData($request){
        return [
            'image' => $request->url,
            'title' => $request->title,
            'description' => $request->description,
            'position' => $request->position,
            'color' => $request->color,
        ];
    }
}