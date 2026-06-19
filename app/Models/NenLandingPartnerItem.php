<?php

namespace App\Models;

use App\Traits\ModelsCommonTrait;
use Illuminate\Database\Eloquent\Model;

class NenLandingPartnerItem extends Model
{
    use ModelsCommonTrait;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
