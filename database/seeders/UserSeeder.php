<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'Test User',
                'phone' => '8888888888',
                'password' => Hash::make('123456'),
                'role' => 'user',
            ]
        );
    }
}
