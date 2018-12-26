<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\Province;
use App\Models\City;

class Shipping extends Model
{
    protected $primaryKey = 'shipping_id';
    
    protected $fillable = [
        'shipping_name', 'customer_id', 'received_name', 'address', 'province_id', 'city_id', 'zip', 'phone', 'default'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }
}