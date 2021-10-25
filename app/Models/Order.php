<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'invoice',
        'grand_total',
        'status',
        'snap_token',
        'phone',
        'full_name',
        'city',
        'province',
        'address',
        'service',
        'courir',
        'cost'
    ];

    public function customer()
    {
        return $this->belongsTo(customer::class);
    }

    public function product()
    {
        return $this->belongsToMany(Product::class)->withPivot('qty');
    }

    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('d-M-Y');
    }
}
