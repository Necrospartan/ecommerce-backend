<?php

namespace Database\Seeders;

use App\Models\Reservation;
use Illuminate\Database\Seeder;
use App\Models\Media;
use Carbon\Carbon;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $media = Media::find(1);

        $startDate = '2025-04-10';
        $endDate = '2025-04-16';
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);
        $reservedDays = [];

        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            $reservedDays[] = $currentDate->toDateString();
            $currentDate->addDay();
        }
        Reservation::create([
            'user_id' => 2,
            'media_id' => $media->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_price' => bcmul($media->price_per_day, count($reservedDays), 2)
        ]);

        $startDate = '2025-04-20';
        $endDate = '2025-04-29';
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);
        $reservedDays = [];

        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            $reservedDays[] = $currentDate->toDateString();
            $currentDate->addDay();
        }
        Reservation::create([
            'user_id' => 2,
            'media_id' => $media->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_price' => bcmul($media->price_per_day, count($reservedDays), 2)
        ]);
//----------------------------------------------------------------------------------------------
        $media = Media::find(2);

        $startDate = '2025-04-15';
        $endDate = '2025-04-25';
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);
        $reservedDays = [];

        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            $reservedDays[] = $currentDate->toDateString();
            $currentDate->addDay();
        }
        Reservation::create([
            'user_id' => 3,
            'media_id' => $media->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_price' => bcmul($media->price_per_day, count($reservedDays), 2)
        ]);

        $startDate = '2025-04-26';
        $endDate = '2025-04-29';
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);
        $reservedDays = [];

        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            $reservedDays[] = $currentDate->toDateString();
            $currentDate->addDay();
        }
        Reservation::create([
            'user_id' => 3,
            'media_id' => $media->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_price' => bcmul($media->price_per_day, count($reservedDays), 2)
        ]);
    }
}
