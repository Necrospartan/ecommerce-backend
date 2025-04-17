<?php

namespace App\Jobs;

use App\Models\Reservation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessPayment implements ShouldQueue
{
    use Queueable;

    private Reservation $reservation;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    public function handle(): void
    {
        sleep(6);
        $this->reservation->update([
            'payment_status' => 'pagado',
        ]);
    }
}
