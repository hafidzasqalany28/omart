<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'discount_percentage',
        'product_id',
        'start_date',
        'end_date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
