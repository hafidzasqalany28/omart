<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'quantity', // tambahkan jika diperlukan
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // app/Models/Order.php
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'price');
    }


    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
