<?php

namespace App\Http\Controllers;

use App\Services\Statistics\StatisticsCollector;
use App\Services\Statistics\NodeCollector;
use Illuminate\Http\Request;
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


    public function index(Request $request): Response {
        $user = $request->user();

        $monthNodeEntries = $this->nodeCollector->collectEntryNodes($user, self::OFFSET_MONTH);

        return Inertia::render('Statistics/Index', [
            'mood' => [
                'band' => $this->statisticsCollector->forMoodBand($monthNodeEntries),
                'chart' => $this->statisticsCollector->forMoodChart($monthNodeEntries)
            ],
        ]);
    }
}
