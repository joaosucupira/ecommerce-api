<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity'
    ];

    
    // 1:1
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    // 1:1
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

    // orders <-> order_items <-> products