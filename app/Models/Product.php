<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'price',
        'active',
    ];

    protected $casts = [
        'price' => 'float',
        'active' => 'boolean',
    ];


    public function categories() 
    {
        return $this->belongsToMany(
            Category::class,
            ProductCategory::class
        );
    }

    public function orderItems()
    {
        return $this->hasMany(
            OrderItem::class,
            
        );
    }

}

    // products <-> product_categories <-> category
    // belongsToMany

    // N
    // product -> N:categorias 
