<?php

namespace App\Models;

use App\Models\OrderOperation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderOperation extends Model
{
    use HasFactory;

    protected $fillable = [
            'order_code',
            'user_id',
            'item_id',
            'type',
            'quantity',
            'total'
    ];

    public function order(){
        return $this->belongsTo(Order::class,'order_code','order_code');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }


    // public function food(){
    //     return $this->hasMany(Food::class,'id','item_id',['type',1]);
    // }

    // public function packages(){
    //     return $this->hasMany(Package::class,'id','item_id',['type',2]);
    // }


    public function food(){

        // if($this->type == 1){
            return $this->belongsTo(Food::class,'item_id','id');
        // }
    }

    public function packages(){
        // if($this->type == 2){
            return $this->belongsTo(Package::class,'item_id','id');
        // }
    }







}