<?php

namespace App\Models;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Food extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description',
        'excerpt',
        'status',
        'category_id',
        'tag_id',
        'image',
        'type',
        'created_at'
    ];

    public function User(){
        return $this->belongsTo(User::class);
    }

    public function Category(){
        return $this->belongsTo(Category::class);
    }


    public function tag(){
        return $this->belongsToMany(Tag::class,'food_tags', 'food_id', 'tag_id');
    }

    public function package(){
        return $this->belongsToMany(Package::class,'package_food','package_id','food_id');
    }
}