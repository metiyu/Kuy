<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $fields = DB::table('fields')
            ->join('venues', 'fields.venue_id', '=', 'venues.id')
            ->select('fields.id as field_id', 'venues.open_hour', 'venues.close_hour')
            ->get();

        $startDate = Carbon::create(2024, 6, 1);
        $endDate = Carbon::create(2024, 7, 1);

        foreach ($fields as $field) {
            for ($date = $startDate->copy(); $date->lessThan($endDate); $date->addDay()) {
                $openHour = Carbon::createFromFormat('H:i:s', $field->open_hour);
                $closeHour = Carbon::createFromFormat('H:i:s', $field->close_hour);

                while ($openHour < $closeHour) {
                    $startHour = $openHour->copy();
                    $endHour = $openHour->addHour();

                    if ($endHour > $closeHour) {
                        break;
                    }

                    DB::table('schedules')->insert([
                        'date' => $date->format('Y-m-d'),
                        'start_hour' => $startHour->format('H:i:s'),
                        'end_hour' => $endHour->format('H:i:s'),
                        'field_id' => $field->field_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $openHour = $endHour;
                }
            }
        }
    }
}
