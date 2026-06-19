<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function getDataAttribute($value){
        return unserialize($value);
    }


}
