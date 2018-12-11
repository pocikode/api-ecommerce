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
        'customer_id', 'received_name', 'address', 'province_id', 'city_id', 'zip', 'phone',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}