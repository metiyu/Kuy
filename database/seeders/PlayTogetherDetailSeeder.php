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
            $this->insertPlayTogetherDetail($playTogether->id, $ownerId);

            // Calculate remaining slots
            $remainingSlots = $playerSlots - 1;

            // Filter out the owner from the user IDs
            $availableUserIds = array_diff($userIds, [$ownerId]);

            // Randomly select users for the remaining slots
            $selectedUsers = [];
            while ($remainingSlots > 3 && count($availableUserIds) > 0) {
                $userId = $faker->randomElement($availableUserIds);
                $this->insertPlayTogetherDetail($playTogether->id, $userId);
                $selectedUsers[] = $userId;
                $remainingSlots--;
                $availableUserIds = array_diff($availableUserIds, $selectedUsers);
            }
        }
    }

    /**
     * Insert a record into the play_together_details table if it doesn't already exist.
     *
     * @param int $playTogetherID
     * @param int $userID
     * @return void
     */
    private function insertPlayTogetherDetail($playTogetherID, $userID)
    {
        // Check if the combination already exists
        $existingRecord = DB::table('play_together_details')
            ->where('play_together_id', $playTogetherID)
            ->where('user_id', $userID)
            ->first();
        if (!$existingRecord) {
            DB::table('play_together_details')->insert([
                'play_together_id' => $playTogetherID,
                'user_id' => $userID,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
