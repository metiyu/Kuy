<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 20) as $index) {
            DB::table('users')->insert([
                'full_name' => 'user'.$index,
                'email' => 'user'.$index.'@mail.com',
                'password' => Hash::make('secret123'),
                'phone_number' => '021123456789'
            ]);
        }
    }
}
