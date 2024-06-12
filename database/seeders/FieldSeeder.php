<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $venueIds = range(1, 50);
        $sportIds = range(1, 10);

        // Shuffle the arrays to randomize venue and sport selection
        shuffle($venueIds);
        shuffle($sportIds);

        foreach ($venueIds as $venueId) {
            // Ensure each venue has at least 2 fields
            $numFields = $faker->numberBetween(2, 5);
            $usedSportIds = [];

            $venueSportIds = $faker->randomElements($sportIds, $faker->numberBetween(1, 3));

            for ($i = 0; $i < $numFields; $i++) {
                $name = 'Hall ' . ($i + 1);
                $isIndoor = $faker->boolean;
                $price = $faker->numberBetween(3, 12) * 10000;
                $picture = 'https://picsum.photos/800/400';

                // $fieldSports = $faker->randomElements($sportIds, $faker->numberBetween(1, 2));
                $sportId = $faker->randomElement($venueSportIds);

                // // Ensure each field has maximum 2 sports
                // foreach ($fieldSports as $sportId) {
                //     if (count($usedSportIds[$venueId] ?? []) < 2 && !in_array($sportId, $usedSportIds[$venueId] ?? [])) {
                //         $usedSportIds[$venueId][] = $sportId;
                //     }
                // }

                // Insert field record
                DB::table('fields')->insert([
                    'name' => $name,
                    'is_indoor' => $isIndoor,
                    'price' => $price,
                    'picture' => $picture,
                    'venue_id' => $venueId,
                    // 'sport_id' => $fieldSports[array_rand($fieldSports)],
                    'sport_id' => $sportId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
