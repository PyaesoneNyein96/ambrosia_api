<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;


class OrderOperation extends Model
{
    use HasFactory;

    protected $fillable = [
            'order_code',
            'user_id',
            'items_id',
            'items_type',
            'quantity',
            'total'
    ];

    public function order() :BelongsTo
    {
        return $this->belongsTo(Order::class,'order_code','order_code');
    }

    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function items() :MorphTo
    {
        return $this->morphTo();
    }


    // public function food(){
    //         return $this->belongsTo(Food::class,'item_id');
    // }

    // public function packages(){
    //         return $this->belongsTo(Package::class,'item_id');
    // }







}
