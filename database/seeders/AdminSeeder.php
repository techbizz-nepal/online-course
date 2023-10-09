<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        if (!User::first()){
            User::create([
                'name' => 'Administrator',
                'username' => 'admin',
                'password' => Hash::make('password'),
                'email' => 'admin@admin.com',
            ]);
        }
    }
}
