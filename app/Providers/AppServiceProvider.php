<?php

namespace App\Providers;

use App\Services\ActivityService;
use App\Services\ActivityServiceInterface;
use App\Services\CollectionService;
use App\Services\CollectionServiceInterface;
use App\Services\EntryService;
use App\Services\EntryServiceInterface;
use App\Services\Photo\PhotoServiceInterface;
use App\Services\Photo\PhotoService;
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
