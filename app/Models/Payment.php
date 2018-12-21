<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $primaryKey = 'order_id';

    protected $fillable = [
        'customer_id', 'order_id', 'invoice', 'to_bank', 'bank_name', 'account_name', 'account_number', 'amount', 'date', 'status'
    ];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_id');
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }

    public function bank()
    {
        return $this->belongsTo('App\Models\Bank', 'to_bank');
    }
}