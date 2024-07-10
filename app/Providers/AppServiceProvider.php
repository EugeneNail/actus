<?php

namespace App\Providers;

use App\Services\Activity\ActivityService;
use App\Services\Activity\ActivityServiceInterface;
use App\Services\Collection\CollectionService;
use App\Services\Collection\CollectionServiceInterface;
use App\Services\Entry\EntryService;
use App\Services\Entry\EntryServiceInterface;
use App\Services\Photo\PhotoService;
use App\Services\Photo\PhotoServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CollectionServiceInterface::class, CollectionService::class);
        $this->app->bind(ActivityServiceInterface::class, ActivityService::class);
        $this->app->bind(EntryServiceInterface::class, EntryService::class);
        $this->app->bind(PhotoServiceInterface::class, PhotoService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
