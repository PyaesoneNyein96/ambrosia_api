<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function orderOperations() :HasMany
    {
        return $this->hasMany(OrderOperation::class,'order_code','order_code');
    }

    public function bookingTable() :HasMany
    {
        return $this->hasMany(BookingTable::class,'order_code','order_code');
    }



}
