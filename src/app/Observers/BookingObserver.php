<?php

namespace App\Observers;

use App\Models\Booking;
use App\Notifications\ResourceBooked;
use Illuminate\Support\Facades\Notification;

class BookingObserver
{
    /**
     * Handle the Booking "created" event.
     */
    public function created(Booking $booking): void
    {
        Notification::route('mail', [
            config('mail.from.address') => config('mail.from.name'),
        ])->notify(new ResourceBooked($booking->load(Booking::MODEL_RELATIONS)));
    }

    /**
     * Handle the Booking "updated" event.
     */
    public function updated(Booking $booking): void
    {
        //
    }

    /**
     * Handle the Booking "deleted" event.
     */
    public function deleted(Booking $booking): void
    {
        //
    }

    /**
     * Handle the Booking "restored" event.
     */
    public function restored(Booking $booking): void
    {
        //
    }

    /**
     * Handle the Booking "force deleted" event.
     */
    public function forceDeleted(Booking $booking): void
    {
        //
    }
}
