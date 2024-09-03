<?php

namespace App\Http\Controllers;

use App\Services\Statistics\StatisticsCollectorInterface;
use App\Services\Statistics\StatisticsServiceInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class StatisticsController extends Controller
{
    private StatisticsCollectorInterface $collector;

    private StatisticsServiceInterface $service;


    public function __construct(StatisticsCollectorInterface $collector, StatisticsServiceInterface $service)
    {
        $this->collector = $collector;
        $this->service = $service;
    }


    public function index(Request $request): Response {
        $user = $request->user();
        $daysAgo = 30;
        $nodeActivities = $this->service->getActivityNodes($user, $daysAgo);
        $nodeEntries = $this->service->getEntryNodes($user, $daysAgo);

        return Inertia::render('Statistics/Index', [
            'table' => $this->collector->forTable($nodeActivities, $user->collections->toArray(), $daysAgo),
            'mood' => [
                'band' => $this->collector->forMoodBand($nodeEntries),
                'chart' => $this->collector->forMoodChart($nodeEntries)
            ],
        ]);
    }
}
