<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class PlayTogetherScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $playTogethers = DB::table('play_togethers')->get();
        $fields = DB::table('fields')->get()->groupBy('venue_id');
        $schedules = DB::table('schedules')->get()->groupBy(['field_id', 'date']); // Group schedules by field and date

        foreach ($playTogethers as $playTogether) {
            // Select a random venue
            $venueIds = $fields->keys()->toArray();
            $randomVenueId = $faker->randomElement($venueIds);
            $venueFields = $fields[$randomVenueId]->pluck('id')->toArray();

            // Collect all schedules for the selected venue
            $venueSchedules = [];
            // foreach ($venueFields as $fieldId) {
            //     foreach ($schedules as $fieldDate => $fieldSchedules) {
            //         [$fieldIdFromSchedules, $dateFromSchedules] = explode('-', $fieldDate);
            //         if ($fieldIdFromSchedules == $fieldId && $dateFromSchedules >= now()->toDateString()) {
            //             $venueSchedules[$dateFromSchedules] = $fieldSchedules;
            //         }
            //     }
            // }
            foreach ($venueFields as $fieldId) {
                foreach ($schedules as $schedule) {
                    $fieldIdFromSchedules = $schedule->field_id;
                    $dateFromSchedules = $schedule->date;
                    if ($fieldIdFromSchedules == $fieldId && $dateFromSchedules >= now()->toDateString()) {
                        $venueSchedules[$dateFromSchedules] = $schedules[$fieldId][$dateFromSchedules];
                    }
                }
            }

            // Ensure there are schedules available for the selected venue
            if (count($venueSchedules) > 0) {
                // Select schedules with adjoining hours on the same date
                foreach ($venueSchedules as $date => $fieldSchedules) {
                    $adjoiningSchedules = $this->getAdjoiningSchedules($fieldSchedules);
                    if (count($adjoiningSchedules) > 0) {
                        // Update the date in play_togethers to match the schedule
                        DB::table('play_togethers')
                            ->where('id', $playTogether->id)
                            ->update(['date' => $date]); // Update date to match schedule date

                        // Insert the transaction details
                        foreach ($adjoiningSchedules as $scheduleId) {
                            DB::table('play_together_schedules')->insert([
                                'play_together_id' => $playTogether->id,
                                'schedule_id' => $scheduleId,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                        break; // Stop processing other dates once found suitable schedules
                    }
                }
            }
        }
    }

    /**
     * Get adjoining schedules on the same date with at least 1-hour gap.
     *
     * @param array $schedules
     * @return array
     */
    private function getAdjoiningSchedules($schedules): array
    {
        $adjoiningSchedules = [];
        $sortedSchedules = collect($schedules)->sortBy('start_hour')->values();

        $previousEndHour = null;
        foreach ($sortedSchedules as $schedule) {
            if (!$previousEndHour || $schedule->start_hour->get($previousEndHour->copy()->addHour())) {
                $adjoiningSchedules[] = $schedule->id;
                $previousEndHour = $schedule->end_hour;
            }
        }

        return $adjoiningSchedules;
    }
}
