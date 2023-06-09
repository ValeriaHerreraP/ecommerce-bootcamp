<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $fillable = [
        'user_id',
        'order_id',
        'url',
        'price_sum',
        'currency', 
        'status', 
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id','user_id');
    }

    public function canceled():void
    {
        $this->update([
            'status' => 'CANCELED'
        ]);
    }

    public function completed():void
    {
        $this->update([
            'status' => 'COMPLETED'
        ]);
    }
}
