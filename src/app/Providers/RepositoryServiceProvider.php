<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\BookingRepository;
use App\Repositories\ResourceRepository;
use App\Contracts\BookingRepositoryInterface;
use App\Contracts\ResourceRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ResourceRepositoryInterface::class, ResourceRepository::class);
        $this->app->bind(BookingRepositoryInterface::class, BookingRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
