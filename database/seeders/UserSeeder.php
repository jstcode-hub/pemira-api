<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->create([
            'npm' => '0',
            'name' => 'root',
            'email' => 'root@pemira.com',
            'password' => Hash::make('password'),
            'role' => 1,
        ]);
    }
}
