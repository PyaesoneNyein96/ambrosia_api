<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingTable extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'time',
        'people',
        'order_code',
        'message',
    ];

    public function order(){
        return $this->belongsTo(Order::class,'order_code','order_code');
    }
}