<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class ProtectedFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'file_path',
        'password',
        'plain_password',
        'description',
        'is_active',
        'last_accessed'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_accessed' => 'datetime',
    ];


    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
        $this->attributes['plain_password'] = $value;
    }

    public function checkPassword($password)
    {
        return Hash::check($password, $this->password);
    }

    public function getFullPathAttribute()
    {
        return database_path('xls/' . $this->file_path);
    }

    public function fileExists()
    {
        return file_exists($this->full_path);
    }

    public function getFileContent()
    {
        if ($this->fileExists()) {
            return file_get_contents($this->full_path);
        }
        return null;
    }

    public function saveFileContent($content)
    {
        $directory = dirname($this->full_path);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
        return file_put_contents($this->full_path, $content);
    }

    public function updateLastAccessed()
    {
        $this->update(['last_accessed' => now()]);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
