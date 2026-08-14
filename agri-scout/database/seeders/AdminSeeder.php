<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $exists = DB::table('USERS')->whereRaw('LOWER(EMAIL) = ?', ['admin@agriscout.com'])->exists();

        if (!$exists) {
            DB::table('USERS')->insert([
                'NAME' => 'System Administrator',
                'EMAIL' => 'admin@agriscout.com',
                'PASSWORD' => Hash::make('Admin@123'),
                'ROLE' => 'admin',
                'STATUS' => 'ACTIVE',
                'CREATED_AT' => now(),
            ]);
        }
    }
}
