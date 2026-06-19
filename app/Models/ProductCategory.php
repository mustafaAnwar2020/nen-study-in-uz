<?php

namespace App\Models;

use App\Traits\ModelsCommonTrait;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use ModelsCommonTrait;

    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }



}
