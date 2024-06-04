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

        foreach ($fields as $field) {
            $openHour = Carbon::createFromFormat('H:i:s', $field->open_hour);
            $closeHour = Carbon::createFromFormat('H:i:s', $field->close_hour);

            while ($openHour < $closeHour) {
                $startHour = $openHour->copy();
                $endHour = $openHour->addHour();

                if ($endHour > $closeHour) {
                    break;
                }

                DB::table('schedules')->insert([
                    'date' => $faker->date(),
                    'start_hour' => $startHour,
                    'end_hour' => $endHour,
                    'field_id' => $field->field_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $openHour = $endHour;
            }
        }
    }
}
