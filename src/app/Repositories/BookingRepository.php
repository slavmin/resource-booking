<?php

namespace App\Repositories;

use App\Contracts\BookingRepositoryInterface;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Collection;

class BookingRepository implements BookingRepositoryInterface
{
    public function all(array $relations = []): Collection
    {
        if (!empty($relations)) {
            return Booking::with($relations)->get();
        }

        return Booking::all();
    }

    public function create(array $data)
    {
        return Booking::query()->create($data);
    }

    public function update(string $id, array $data): bool
    {
        $booking = Booking::query()->findOrFail($id);

        return $booking->update($data);
    }

    public function delete(string $id): ?bool
    {
        $booking = Booking::query()->findOrFail($id);

        return $booking->delete();
    }
}
