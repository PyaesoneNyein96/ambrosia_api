<?php

namespace App\Models;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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

    public function tag() :BelongsToMany
    {
        return $this->belongsToMany(Tag::class,'food_tags', 'food_id', 'tag_id');
    }

    public function package() :BelongsToMany
    {
        return $this->belongsToMany(Package::class,'package_food','package_id','food_id');
    }


    public function orderOperation() :MorphMany
    {
        return $this->morphMany(OrderOperation::class,'items');
    }

    public function user() :BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }


}
