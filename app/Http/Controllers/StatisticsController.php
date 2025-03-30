<?php

namespace App\Http\Controllers;

use App\Enums\StatisticsPeriod;
use App\Http\Requests\StatisticsIndexRequest;
use App\Services\Statistics\StatisticsCollector;
use App\Services\Statistics\NodeCollector;
use Inertia\Inertia;
use Inertia\Response;

class StatisticsController extends Controller
{
    const OFFSET_MONTH = 30;

    private StatisticsCollector $statisticsCollector;

    private NodeCollector $nodeCollector;


    public function __construct(StatisticsCollector $collector, NodeCollector $service)
    {
        $this->statisticsCollector = $collector;
        $this->nodeCollector = $service;
    }


    public function index(StatisticsIndexRequest $request): Response {
        $period = $request->period == StatisticsPeriod::MONTH->toString() ? StatisticsPeriod::MONTH->value : StatisticsPeriod::YEAR->value;
        $dates = [];
        for ($i = 0; $i < $period; $i++) {
            $dates[] = date('Y-m-d', strtotime("-$i days"));
        }

        $user = $request->user();
        $entries = $user->entries()->with('goals')->get();

        $monthNodeEntries = $this->nodeCollector->collectEntryNodes($user, self::OFFSET_MONTH);

        return Inertia::render('Statistics/Index', [
            'mood' => [
                'band' => $this->statisticsCollector->forMoodBand($monthNodeEntries),
                'chart' => $this->statisticsCollector->forMoodChart($dates, $entries)
            ],
            'goalChart' => $this->statisticsCollector->forGoalChart($dates, $entries, $user->goals->count()),
        ]);
    }
}
