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

    // * Um produto pode pertencer a várias categorias

    public function categories() 
    {
        return $this->belongsToMany(
            Category::class,
            ProductCategory::class
        );
    }

    // * Um produto pode estar em vários pedidos

    public function orders()
    {
        return $this->belongsToMany(
            Order::class,
            OrderItem::class,
        );
    }
}

    // products <-> product_categories <-> category
    // belongsToMany

    // N    
    // product -> N:categorias 

