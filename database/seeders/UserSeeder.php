<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {

        User::query()->create([
            'username' => 'admin',
            'name' => 'Admin',
            'email' => 'admin@nen.com',
            'phone' => '021212121',
            'password' => Hash::make('2025_m10'),
            'is_admin' => 1,
        ]);

    }
}
