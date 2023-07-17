<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_details';

    protected $fillable = [
    'user_id',
    'order_id',
    'name',
    'price',
    'quantity',
    'subtotal',
    'total',
    ];

    public function userId(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function orderId(): HasOne
    {
        return $this->hasOne(Payment::class, 'id', 'order_id');
    }
}
