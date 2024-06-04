<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class TransactionDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $transactions = DB::table('transactions')->get();
        $fields = DB::table('fields')->get()->groupBy('venue_id');
        $schedules = DB::table('schedules')->get()->groupBy('field_id');

        foreach ($transactions as $transaction) {
            // Select a random venue
            $venueIds = $fields->keys()->toArray();
            $randomVenueId = $faker->randomElement($venueIds);
            $venueFields = $fields[$randomVenueId]->pluck('id')->toArray();

            // Collect all schedules for the selected venue
            $venueSchedules = [];
            foreach ($venueFields as $fieldId) {
                if (isset($schedules[$fieldId])) {
                    $venueSchedules = array_merge($venueSchedules, $schedules[$fieldId]->pluck('id')->toArray());
                }
            }

            // Ensure there are schedules available for the selected venue
            if (count($venueSchedules) > 0) {
                // Select between 1 and 5 schedules for the transaction
                $scheduleCount = $faker->numberBetween(1, 5);
                $selectedSchedules = $faker->randomElements($venueSchedules, $scheduleCount);

                // Insert the transaction details
                foreach ($selectedSchedules as $scheduleId) {
                    DB::table('transaction_details')->insert([
                        'transaction_id' => $transaction->id,
                        'schedule_id' => $scheduleId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
