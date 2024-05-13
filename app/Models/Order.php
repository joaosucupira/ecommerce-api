<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
    ];

    protected $casts = [
        'code' => 'integer',
    ];

    // * Um pedido pertence a apenas UM cliente

    public function users() 
    {
        return $this->belogsTo(
            User::class,
        );
    }

    // * Um pedido pode ter vários produtos

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            OrderItem::class,
        );
    }

}

// order <-> order_items <-> products