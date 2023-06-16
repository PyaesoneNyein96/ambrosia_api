<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class packageFood extends Model
{
    use HasFactory;

    protected $fillable = ['food_id','package_id'];
}