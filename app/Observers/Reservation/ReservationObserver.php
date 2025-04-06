<?php

namespace App\Observers\Reservation;

use App\Models\Availability;
use App\Models\Reservation;
use Carbon\Carbon;

class ReservationObserver
{
    /**
     * Handle the Reservation "created" event.
     */
    public function created(Reservation $reservation): void
    {
        $mediaId = $reservation->media_id;

        $startDate = Carbon::parse($reservation->start_date);
        $endDate = Carbon::parse($reservation->end_date);

        while ($startDate->lte($endDate)) {
            Availability::create([
                'reservation_id' => $reservation->id,
                'media_id' => $mediaId,
                'reserved_date' => $startDate->toDateString(),
            ]);
            $startDate->addDay();
        }
    }

    /**
     * Handle the Reservation "updated" event.
     */
    public function updated(Reservation $reservation): void
    {
        $reservation->availability()->delete();

        $mediaId = $reservation->media_id;

        $startDate = Carbon::parse($reservation->start_date);
        $endDate = Carbon::parse($reservation->end_date);

        while ($startDate->lte($endDate)) {
            Availability::create([
                'reservation_id' => $reservation->id,
                'media_id' => $mediaId,
                'reserved_date' => $startDate->toDateString(),
            ]);
            $startDate->addDay();
        }
    }

    /**
     * Handle the Reservation "deleted" event.
     */
    public function deleted(Reservation $reservation): void
    {
        //
    }

    /**
     * Handle the Reservation "restored" event.
     */
    public function restored(Reservation $reservation): void
    {
        //
    }

    /**
     * Handle the Reservation "force deleted" event.
     */
    public function forceDeleted(Reservation $reservation): void
    {
        //
    }
}
