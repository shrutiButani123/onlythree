<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'subcategory_id',
        'price',
        'image',
        'description'
    ];

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
