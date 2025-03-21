<?php

namespace App\Services;

use App\Contracts\BookingRepositoryInterface;
use App\Models\Booking;
use Carbon\CarbonPeriod;
use Illuminate\Contracts\Database\Eloquent\Builder;

class BookingService
{
    public function __construct(protected BookingRepositoryInterface $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    public function getAll(array $relations = [])
    {
        return $this->bookingRepository->all($relations);
    }

    public function create(array $data)
    {
        $args = collect($data)->only(['resource_id', 'start_time', 'end_time'])
            ->values()->toArray();

        if (!static::isBookingAvailable(...$args)) {
            throw new \InvalidArgumentException('Not available', 400);
        }

        return $this->bookingRepository->create($data);
    }

    public function update(string $id, array $data)
    {
        return $this->bookingRepository->update($id, $data);
    }

    public function delete(string $id)
    {
        return $this->bookingRepository->delete($id);
    }

    public function isBookingAvailable(string $resourceId, string $startTime, string $endTime): bool
    {
        $bookingPeriod = CarbonPeriod::create($startTime, $endTime);

        return !Booking::query()->where('resource_id', $resourceId)
            ->where(fn(Builder $query) => $query
                ->whereBetween('start_time', $bookingPeriod)
                ->orWhereBetween('end_time', $bookingPeriod)
            )->exists();
    }
}
