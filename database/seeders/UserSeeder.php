<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        //user create
        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '08123456789',
            'roles' => 'ADMIN',
        ]);

        //user create roles user
        \App\Models\User::create([
            'name' => 'Husyam',
            'email' => 'husyam59@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '08123456789',
            'roles' => 'USER',
        ]);
    }
}
