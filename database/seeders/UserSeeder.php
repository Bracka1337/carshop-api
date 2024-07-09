<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'username' => 'user1',
                'password' => Hash::make('password1'),
                'email' => 'user1@example.com',
                'phone_nr' => '1234567890',
                'role' => 'admin',
                'name' => 'Somebody'
                
            ],
            [
                'username' => 'user2',
                'password' => Hash::make('password2'),
                'email' => 'user2@example.com',
                'phone_nr' => '0987654321',
                'role' => 'user',
                'name' => 'Somebody2'

            ]
        ]);
    }
}
