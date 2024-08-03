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
        $nodes = $this->service->getNodes($user, 15);
        $tableStatistics = $this->collector->forTable($nodes, $user->collections->toArray());

        return Inertia::render('Statistics/Index', [
            'table' => $tableStatistics,
        ]);
    }
}
