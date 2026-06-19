<?php

namespace App\Models;

use App\Traits\ModelsCommonTrait;
use Illuminate\Database\Eloquent\Model;

class Network extends Model
{
    use ModelsCommonTrait;

    protected $guarded = [];


    public const TYPES = [
        'test-sites' => 'Test sites',
        'teachers' => 'Teachers / Trainers',
    ];

}
