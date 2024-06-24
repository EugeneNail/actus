<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use service\ActivityService;
use service\ActivityServiceInterface;
use service\CollectionService;
use service\CollectionServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CollectionServiceInterface::class, CollectionService::class);
        $this->app->bind(ActivityServiceInterface::class, ActivityService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
