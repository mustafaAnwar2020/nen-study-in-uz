<?php

namespace App\Models;

use App\Traits\ModelsCommonTrait;
use App\Traits\HasLocalizedAttributes;
use Illuminate\Database\Eloquent\Model;

class NenLandingPartnerItem extends Model
{
    use ModelsCommonTrait, HasLocalizedAttributes;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
