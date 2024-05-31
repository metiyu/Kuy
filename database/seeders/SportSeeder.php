<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sports')->insert([
            'name' => 'Sepak Bola',
            'icon' => 'https://api.ayo.co.id/assets/img/football.png'
        ]);
        DB::table('sports')->insert([
            'name' => 'Futsal',
            'icon' => 'https://api.ayo.co.id/assets/img/football.png'
        ]);
        DB::table('sports')->insert([
            'name' => 'Basketball',
            'icon' => 'https://api.ayo.co.id/assets/img/basketball.png'
        ]);
        DB::table('sports')->insert([
            'name' => 'Tennis',
            'icon' => 'https://api.ayo.co.id/assets/img/tennis.png'
        ]);
        DB::table('sports')->insert([
            'name' => 'Tenis Meja',
            'icon' => 'https://api.ayo.co.id/assets/img/table_tennis.png'
        ]);
        DB::table('sports')->insert([
            'name' => 'Billiard',
            'icon' => 'https://api.ayo.co.id/assets/img/billiard.png'
        ]);
        DB::table('sports')->insert([
            'name' => 'Golf',
            'icon' => 'https://api.ayo.co.id/assets/img/golf.png'
        ]);
        DB::table('sports')->insert([
            'name' => 'Padel',
            'icon' => 'https://api.ayo.co.id/assets/img/padel.png'
        ]);
        DB::table('sports')->insert([
            'name' => 'Hockey',
            'icon' => 'https://api.ayo.co.id/assets/img/hockey.png'
        ]);
        DB::table('sports')->insert([
            'name' => 'Volley',
            'icon' => 'https://api.ayo.co.id/assets/img/volley.png'
        ]);
    }
}
