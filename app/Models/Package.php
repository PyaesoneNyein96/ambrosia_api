<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;


class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sub_total',
        'net_total',
        'percentage'
    ];

    public function food() :BelongsToMany
    {
        return $this->belongsToMany(Food::class,'package_food','package_id','food_id');
    }


    public function orderOperation() :MorphMany
    {
        return $this->morphMany(OrderOperation::class,'items');
    }




}
