<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use service\ActivityService;
use service\ActivityServiceInterface;
use service\CollectionService;
use service\CollectionServiceInterface;
use service\EntryService;
use service\EntryServiceInterface;

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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
