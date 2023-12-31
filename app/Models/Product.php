<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
        'image',
        'quantity',
    ];

    public function reduceStock($quantity)
    {
        $this->decrement('quantity', $quantity);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity', 'price');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function promos()
    {
        return $this->hasMany(Promo::class);
    }

    public function payments()
    {
        return $this->hasManyThrough(Payment::class, Order::class);
    }
}
