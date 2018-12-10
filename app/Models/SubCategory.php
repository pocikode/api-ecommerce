<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $primaryKey = 'sub_category_id';

    protected $fillable = ['category_id', 'category_name', 'name', 'icon'];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}