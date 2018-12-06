<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    protected $primaryKey = 'courier_id';

    protected $fillable = ['name'];

    protected $hidden = ['created_at', 'updated_at'];
}