<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PlayTogetherScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $playTogethers = DB::table('play_togethers')->get();
        $schedules = DB::table('schedules')
            ->join('fields', 'schedules.field_id', '=', 'fields.id')
            ->select('schedules.*', 'fields.sport_id as field_sport_id')
            ->get()
            ->groupBy('date');

        foreach ($playTogethers as $playTogether) {
            // Ensure there are schedules available
            if ($schedules->isEmpty()) {
                continue;
            }

            // Filter schedules by sport_id
            $filteredSchedulesBySport = $schedules->map(function ($dateSchedules) use ($playTogether) {
                return $dateSchedules->filter(function ($schedule) use ($playTogether) {
                    return $schedule->field_sport_id == $playTogether->sport_id;
                });
            })->filter(function ($dateSchedules) {
                return !$dateSchedules->isEmpty();
            });

            // Ensure there are schedules available after filtering
            if ($filteredSchedulesBySport->isEmpty()) {
                continue;
            }

            // Select a random date
            $randomDate = $faker->randomElement($filteredSchedulesBySport->keys());
            $dateSchedules = $filteredSchedulesBySport->get($randomDate);

            // Filter schedules with adjoining hours
            $filteredSchedules = $this->getAdjoinedSchedules($dateSchedules);

            // Insert the play together schedules
            if (count($filteredSchedules) > 0) {
                $startTime = $filteredSchedules->sortBy('start_hour')->first()->start_hour;
                $endTime = $filteredSchedules->sortByDesc('end_hour')->first()->end_hour;
                $date = Carbon::createFromFormat('Y-m-d', $randomDate);

                foreach ($filteredSchedules as $schedule) {
                    // Check if the combination already exists
                    $existingRecord = DB::table('play_together_schedules')
                        ->where('play_together_id', $playTogether->id)
                        ->where('schedule_id', $schedule->id)
                        ->first();

                    if (!$existingRecord) {
                        DB::table('play_together_schedules')->insert([
                            'play_together_id' => $playTogether->id,
                            'schedule_id' => $schedule->id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }

                // Update the date, start_hour, and end_hour in play_togethers
                DB::table('play_togethers')
                    ->where('id', $playTogether->id)
                    ->update([
                        'date' => $date->toDateString(),
                        'start_hour' => $startTime,
                        'end_hour' => $endTime
                    ]);
            }
        }
    }

    /**
     * Get adjoined schedules for a given date.
     *
     * @param \Illuminate\Support\Collection $dateSchedules
     * @return \Illuminate\Support\Collection
     */
    private function getAdjoinedSchedules($dateSchedules)
    {
        $adjoinedSchedules = collect();
        $previousEndHour = null;

        foreach ($dateSchedules->sortBy('start_hour') as $schedule) {
            $startHour = Carbon::createFromFormat('H:i:s', $schedule->start_hour);
            $endHour = Carbon::createFromFormat('H:i:s', $schedule->end_hour);

            if ($previousEndHour === null || $startHour->eq($previousEndHour)) {
                $adjoinedSchedules->push($schedule);
                $previousEndHour = $endHour;
            } else {
                break;
            }
        }

        return $adjoinedSchedules;
    }
}
