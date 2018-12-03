<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'code', 'name', 'category_id', 'sub_category_id', 'brand_id', 'point', 'price', 'weight', 'image1', 'description', 'status', 'sold', 'hit_views'
    ];
}