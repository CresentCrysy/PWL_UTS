<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'level_id'  => 1,
                'username'  => 'admin',
                'nama'      => 'Administrator',
                'email'     => 'admin@pos.com',
                'password'  => Hash::make('password'),
            ],
            [
                'level_id'  => 2,
                'username'  => 'manager',
                'nama'      => 'Manager Toko',
                'email'     => 'manager@pos.com',
                'password'  => Hash::make('password'),
            ],
            [
                'level_id'  => 3,
                'username'  => 'kasir01',
                'nama'      => 'Kasir Satu',
                'email'     => 'kasir@pos.com',
                'password'  => Hash::make('password'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}

