<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

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
        return $this->belongsToMany(Order::class)->withPivot('qty', 'price');
    }

    public function customer()
    {
        return $this->belongsToMany(Customer::class)->withPivot('qty');
    }

    public function Discount()
    {
        return $this->hasOne(Discount::class, 'product_id');
    }

    public function review()
    {
        return $this->belongsToMany(Customer::class, 'reviews')->withPivot('star', 'review', 'image_review')->withTimestamps()->latest('pivot_created_at');
    }
}
