<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Governorate extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function students(): HasMany
    {
        return $this->hasMany(User::class, 'address_governorate_id', 'id')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'student');
            });
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }

}
