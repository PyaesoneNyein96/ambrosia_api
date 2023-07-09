<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_code',
        'status',
        'sub_total',
        'total'
    ];



    public function user(){
        return $this->belongsTo(User::class);
    }

    public function orderOperations(){
        return $this->hasMany(Order::class,'order_code','order_code');
    }

    public function bookingTable(){
        return $this->hasMany(bookingTable::class,'order_code','order_code');
    }



}