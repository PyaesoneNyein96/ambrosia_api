<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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



    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderOperations() :BelongsTo
    {
        return $this->hasMany(Order::class,'order_code','order_code');
    }

    public function bookingTable() :BelongsTo
    {
        return $this->hasMany(BookingTable::class,'order_code','order_code');
    }



}
