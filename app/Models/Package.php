<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sub_total',
        'net_total',
        'percentage'
    ];

    public function food() :BelongsTo
    {
        return $this->belongsToMany(Food::class,'package_food','package_id','food_id');
    }


    public function orderOperation(){
        return $this->morphMany(OrderOperation::class,'items');
    }




}