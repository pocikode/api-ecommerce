<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'order_id';

    protected $fillable = [
        'invoice', 'customer_id', 'amount', 'shipping_cost', 'total_payment', 'received_name', 'address', 'province_id', 'city_id', 'zip', 'phone', 'due_date', 'awb', 'status'
    ];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_id');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id');
    }

    public function province()
    {
        return $this->belongsTo('App\Models\Province', 'province_id');
    }

    public function details()
    {
        return $this->hasMany('App\Models\OrderDetail', 'order_id');
    }

    public function payment()
    {
        return $this->hasOne('App\Models\Payment', 'order_id');
    }
}