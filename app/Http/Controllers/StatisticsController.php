<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Models\Support\NodeActivity;
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

        $tableStatistics = $this->collector->forTable($nodeActivities, $user->collections->toArray(), $daysAgo);

        return Inertia::render('Statistics/Index', [
            'table' => $tableStatistics,
        ]);
    }
}
