<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'John Farmer',
                'email' => 'farmer@agriscout.com',
                'password' => Hash::make('Farmer@123'),
                'role' => 'farmer',
                'status' => 'ACTIVE',
                'created_at' => now(),
            ],
            [
                'name' => 'Sarah Field Officer',
                'email' => 'officer@agriscout.com',
                'password' => Hash::make('Officer@123'),
                'role' => 'field_officer',
                'status' => 'ACTIVE',
                'created_at' => now(),
            ],
            [
                'name' => 'David Customer',
                'email' => 'customer@agriscout.com',
                'password' => Hash::make('Customer@123'),
                'role' => 'customer',
                'status' => 'ACTIVE',
                'created_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            $exists = DB::table('USERS')->whereRaw('LOWER(email) = ?', [strtolower($user['email'])])->exists();
            if (!$exists) {
                DB::table('USERS')->insert($user);
            }
        }
    }
}
