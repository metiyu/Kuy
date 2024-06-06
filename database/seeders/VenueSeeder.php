<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class VenueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 50) as $index) {
            $openHours = ['06:00:00', '07:00:00', '08:00:00', '09:00:00', '10:00:00'];
            $closeHours = ['21:00:00', '22:00:00', '23:00:00', '24:00:00'];
            $openHourIndex = array_rand($openHours);
            $closeHourIndex = array_rand($closeHours);

            DB::table('venues')->insert([
                'name' => $faker->company,
                'description' => $faker->sentence,
                'location' => $faker->cityPrefix.', '.$faker->city,
                'open_hour' => $openHours[$openHourIndex],
                'close_hour' => $closeHours[$closeHourIndex],
                'owner_id' => $faker->numberBetween(1, 20), // Assuming you have 10 users
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
