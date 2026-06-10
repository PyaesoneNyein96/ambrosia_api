<?php

namespace App\Models;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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


    public function Category() :BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tag() :BelongsTo
    {
        return $this->belongsToMany(Tag::class,'food_tags', 'food_id', 'tag_id');
    }

    public function package() :BelongsTo
    {
        return $this->belongsToMany(Package::class,'package_food','package_id','food_id');
    }


    public function orderOperation() :BelongsTo
    {
        return $this->morphMany(OrderOperation::class,'items');
    }

    public function user() :BelongsTo
    {
        return $this->belongsToMany(User::class);
    }


}