<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'code', 'name', 'category_id', 'category_name', 'sub_category_id', 'sub_category_name', 'brand_id', 'point', 'price', 'weight', 'image', 'description', 'status', 'sold', 'hit_views', 'sizes', 'stocks',
    ];
}