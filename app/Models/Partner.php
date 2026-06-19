<?php

namespace App\Models;

use App\Traits\ModelsCommonTrait;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use ModelsCommonTrait;

    protected $guarded = [];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
