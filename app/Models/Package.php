<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sub_total',
        'net_total',
        'percentage'
    ];

    public function food(){
        return $this->belongsToMany(Food::class,'package_food','package_id','food_id');
    }

    // public function orderOperations(){
    //     return $this->belongsTo(OrderOperations::class,'item_id','id')->where('type',2);
    // }




}