<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $fillable = ['name', 'email', 'password', 'avatar'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function product()
    {
        return $this->belongsToMany(Product::class)->withPivot('qty');
    }

    public function getAvatarAttribute($avatar)
    {
        if ($avatar != null) :
            return asset('storage/customer/' . $avatar);
        else :
            return 'https://ui-avatars.com/api/?name=' . str_replace(' ', '+', $this->name) . '&background=4e73df&color=ffffff&size=100';
        endif;
    }

    public function total()
    {
        return $this->belongsToMany(Product::class)->withPivot('qty')->selectRaw('price * qty as total');
    }
}
