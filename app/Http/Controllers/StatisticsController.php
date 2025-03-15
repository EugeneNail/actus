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

    private StatisticsCollectorInterface $collector;

    private StatisticsServiceInterface $service;


    public function __construct(StatisticsCollectorInterface $collector, StatisticsServiceInterface $service)
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
