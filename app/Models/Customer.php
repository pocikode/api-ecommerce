<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Customer extends Model
{
    use Authenticatable, Authorizable;
    
    protected $primaryKey = 'customer_id';

    protected $fillable = [
        'name', 'address', 'city', 'province', 'zip', 'phone', 'email', 'password', 'photo', 'point'
    ];

    protected $hidden = [
        'password'
    ];

    public function cart()
    {
        return $this->hasOne('App\Cart', 'customer_id');
    }

    public function shipping()
    {
        return $this->hasOne('App\Shipping', 'customer_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Order', 'customer_id');
    }
}