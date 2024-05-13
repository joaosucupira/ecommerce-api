<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;

    //* Um status de pedido pode estar em vários pedidos

    public function orders()
    {
        return $this->hasMany(
            Order::class
        );
    }
}
