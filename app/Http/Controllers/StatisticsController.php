<?php

namespace App\Http\Controllers;

use App\Services\Statistics\StatisticsCollectorInterface;
use App\Services\Statistics\StatisticsServiceInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class StatisticsController extends Controller
{
    const OFFSET_MONTH = 30;

    const OFFSET_YEAR = 365;

    private StatisticsCollectorInterface $collector;

    private StatisticsServiceInterface $service;


    public function __construct(StatisticsCollectorInterface $collector, StatisticsServiceInterface $service)
    {
        $this->collector = $collector;
        $this->service = $service;
    }


    public function index(Request $request): Response {
        $user = $request->user();

        $monthNodeActivities = $this->service->getActivityNodes($user, self::OFFSET_MONTH);
        $monthNodeEntries = $this->service->getEntryNodes($user, self::OFFSET_MONTH);

        $yearNodeActivities = $this->service->getActivityNodes($user, self::OFFSET_YEAR);

        return Inertia::render('Statistics/Index', [
            'table' => $this->collector->forTable($monthNodeActivities, $user->collections->toArray(), self::OFFSET_MONTH),
            'mood' => [
                'band' => $this->collector->forMoodBand($monthNodeEntries),
                'chart' => $this->collector->forMoodChart($monthNodeEntries)
            ],
            'frequency' => [
                'month' => $this->collector->forFrequency($monthNodeActivities, 9),
                'year' => $this->collector->forFrequency($yearNodeActivities, 9)
            ]
        ]);
    }
}
