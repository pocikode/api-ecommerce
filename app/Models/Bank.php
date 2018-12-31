<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $primaryKey = 'bank_id';

    protected $fillable = ['bank_name', 'account_name', 'account_number', 'description'];
    protected $hidder = ['created_at', 'updated_at'];
}