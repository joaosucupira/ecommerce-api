<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity'
    ];

    public function product()
    {
        // Siginifa que é uma relacao 1:1 e que a chave está nessa tabela
        return $this->belongsTo(Product::class);
    }
}

    // orders <-> order_items <-> products