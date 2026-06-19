<?php

namespace App\Models;

use App\Traits\ModelsCommonTrait;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use ModelsCommonTrait;

    protected $guarded = [];

    public function getList()
    {
        return $this->list_items ? json_decode($this->list_items) : [];
    }

}
