<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'food_id',
        'package_id'
    ];

    public function food() :BelongsTo
    {
        return $this->belongsTo(Food::class);
    }


    public function package() :BelongsTo
    {
        return $this->belongsTo(Package::class,'package_id');
    }



}
