<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class PlayTogetherDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $playTogethers = DB::table('play_togethers')->get();
        $userIds = range(1, 20);

        foreach ($playTogethers as $playTogether) {
            $ownerId = $playTogether->owner_id;
            $playerSlots = $playTogether->player_slot;

            // Insert the owner into play_together_details
            DB::table('play_together_details')->insert([
                'play_together_id' => $playTogether->id,
                'user_id' => $ownerId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Calculate remaining slots
            $remainingSlots = $playerSlots - 1;

            // Filter out the owner from the user IDs
            $availableUserIds = array_diff($userIds, [$ownerId]);

            // Randomly select users for the remaining slots
            $selectedUserIds = $faker->randomElements($availableUserIds, $remainingSlots);

            // Insert the selected users into play_together_details
            foreach ($selectedUserIds as $userId) {
                DB::table('play_together_details')->insert([
                    'play_together_id' => $playTogether->id,
                    'user_id' => $userId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
