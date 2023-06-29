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



    public function food(){
            return $this->belongsTo(Food::class,'item_id');
    }

    public function packages(){
            return $this->belongsTo(Package::class,'item_id');
    }







}