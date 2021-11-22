<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'discount', 'price_discount', 'start', 'end'];

    public function Product()
    {
        return $this->hasOne(Product::class, 'product_id');
    }
}
