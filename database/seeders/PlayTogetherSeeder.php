<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PlayTogetherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $ownerIds = range(1, 20);
        $sportIds = range(1, 10);
        $prices = range(20000, 100000, 10000);

        foreach (range(1, 50) as $index) {
            DB::table('play_togethers')->insert([
                'name' => $faker->company,
                'description' => $faker->sentence(3),
                'player_slot' => $faker->numberBetween(2, 20),
                'price' => $faker->randomElement($prices),
                'date' => Carbon::now(),
                'start_hour' => '00:00:00',
                'end_hour' => '00:00:00',
                'owner_id' => $faker->randomElement($ownerIds),
                'sport_id' => $faker->randomElement($sportIds),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
