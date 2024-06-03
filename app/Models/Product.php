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
        'path',
    ];

    protected $casts = [
        'price' => 'float',
        'active' => 'boolean',
    ];

    protected $attributes = [
        'path'=>null,
        'active'=>true,
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function(self $product){
            $product->slug= !$product->slug ? \Str::slug($product->name) : $product->slug;
        });
    }

    // N : N
    public function categories() 
    {
        return $this->belongsToMany(
            Category::class,
            ProductCategory::class
        );
    }

    // n:n
    public function orders()
    {
        return $this->belongsToMany(
            Order::class,
            OrderItem::class,
        );
    }

    // 1:n
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}

    // products <-> product_categories <-> category
    // belongsToMany

    // N    
    // product -> N:categorias 

