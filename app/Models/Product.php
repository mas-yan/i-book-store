<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'price', 'title', 'slug', 'stok', 'detail_product', 'image'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getImageAttribute($image)
    {
        return asset('storage/products/' . basename($image));
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function order()
    {
        return $this->belongsToMany(Order::class);
    }

    public function customer()
    {
        return $this->belongsToMany(Customer::class);
    }
}
