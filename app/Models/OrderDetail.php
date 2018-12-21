<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $primaryKey = 'order_detail_id';

    protected $fillable = [
        'order_id', 'product_id', 'product_code', 'product_name', 'size', 'price'
    ];

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }
}