<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'category_id';

    protected $fillable = ['name'];

    public function subCategories()
    {
        return $this->hasMany('App\SubCategory');
    }
}