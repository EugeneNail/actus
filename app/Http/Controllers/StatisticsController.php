<?php

namespace App\Http\Controllers;

use App\Services\Statistics\StatisticsCollector;
use App\Services\Statistics\StatisticsService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class StatisticsController extends Controller
{
    const OFFSET_MONTH = 30;

    private StatisticsCollector $collector;

    private StatisticsService $service;


    public function __construct(StatisticsCollector $collector, StatisticsService $service)
    {
        $this->collector = $collector;
        $this->service = $service;
    }


    public function index(Request $request): Response {
        $user = $request->user();

        $monthNodeEntries = $this->service->getEntryNodes($user, self::OFFSET_MONTH);

        return Inertia::render('Statistics/Index', [
            'mood' => [
                'band' => $this->collector->forMoodBand($monthNodeEntries),
                'chart' => $this->collector->forMoodChart($monthNodeEntries)
            ],
        ]);
    }
}
