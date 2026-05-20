<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'food_id',
        'package_id'
    ];

    public function food(){
        return $this->belongsTo(Food::class);
    }


    public function package(){
        return $this->belongsTo(Package::class,'package_id');
    }



}
