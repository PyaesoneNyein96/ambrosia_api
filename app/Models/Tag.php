<?php

namespace App\Models;

use App\Models\Food;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];


    public function food() :BelongsToMany
    {
        return $this->belongsToMany(Food::class,'food_tags', 'tag_id', 'food_id');
    }
}
