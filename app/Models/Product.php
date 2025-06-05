<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'english_name', 
        'name', 
        'description', 
        'price', 
        'stock', 
        'discount',
        'image',
        'tags'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
