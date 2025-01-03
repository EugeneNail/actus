<?php

namespace App\Providers;

use App\Services\Activity\ActivityService;
use App\Services\Activity\ActivityServiceInterface;
use App\Services\Collection\CollectionService;
use App\Services\Collection\CollectionServiceInterface;
use App\Services\Entry\EntryService;
use App\Services\Entry\EntryServiceInterface;
use App\Services\Goal\GoalService;
use App\Services\Goal\GoalServiceInterface;
use App\Services\Photo\PhotoService;
use App\Services\Photo\PhotoServiceInterface;
use App\Services\Statistics\StatisticsCollector;
use App\Services\Statistics\StatisticsCollectorInterface;
use App\Services\Statistics\StatisticsService;
use App\Services\Statistics\StatisticsServiceInterface;
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
        $this->app->bind(StatisticsCollectorInterface::class, StatisticsCollector::class);
        $this->app->bind(StatisticsServiceInterface::class, StatisticsService::class);
        $this->app->bind(GoalServiceInterface::class, GoalService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
