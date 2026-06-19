<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getStatus(): string
    {
        return match ($this->is_done) {
            1 => 'Contacted',
            default => 'New',
        };
    }



}
