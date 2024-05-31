<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $paymentMethods = ['Mobile Banking', 'QRIS', 'Credit Card', 'Cash'];
        $userIds = range(1, 20);

        // Generate dates from oldest to newest
        $dates = [];
        $startDate = strtotime('-1 year');
        $endDate = strtotime('now');
        for ($timestamp = $startDate; $timestamp <= $endDate; $timestamp += 86400) { // 86400 seconds = 1 day
            $dates[] = date('Y-m-d', $timestamp);
        }

        foreach ($dates as $date) {
            $paymentMethod = $paymentMethods[array_rand($paymentMethods)];
            $userId = $faker->randomElement($userIds);

            DB::table('transactions')->insert([
                'date' => $date,
                'payment_method' => $paymentMethod,
                'user_id' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
