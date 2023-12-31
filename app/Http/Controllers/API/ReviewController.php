<?php

namespace App\Http\Controllers\API;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    //

    public function submit_review(Request $request){


       $review = Review::create([
            'user_id' => $request->user_id,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'rating' => $request->rating,
        ]);

        return Review::all();
    }


    public function review_list(Request $request){

        return Review::with('user')->orderBy('created_at','desc')->get();

    }






}