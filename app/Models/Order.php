<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'code',
    ];

    protected $casts = [
        'code' => 'integer',
    ];

    // 1:1
    public function user() 
    {
        return $this->belogsTo(
            User::class,
        );
    }

    // 1:n
    public function orderItems()
    {
        return $this->hasMany(
            OrderItem::class
        );
    }

    // 1:n
    public function orderStatuses()
    {
        return $this->hasMany(orderStatus::class);
    }

    // n:n
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items')
            ->withPivot('quantity')
            ->withTimestamps();
    }

}

// order <-> order_items <-> products