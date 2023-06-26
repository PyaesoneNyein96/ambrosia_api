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
        'total'
    ];

    public function orderOperations(){
        return $this->hasMany(Order::class,'order_code','order_code');
    }


    public function user(){
        return $this->belongsTo(User::class);
    }
}