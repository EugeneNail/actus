<?php

namespace App\Services\Statistics;

use App\Models\Support\MoodBand;
use App\Models\Support\NodeEntry;
use App\Models\Support\NodeGoal;

interface StatisticsCollectorInterface
{
    /** @param NodeEntry[] $nodes */
    public function forMoodBand(array $nodes): MoodBand;


    /**
     * @param NodeEntry[] $nodes
     * @return iterable<int>
     */
    public function forMoodChart(array $nodes): iterable;


    /**
     * @param NodeGoal[] $nodes
     * @return iterable
     */
    public function forGoalHeatmap(array $nodes, int $daysAgo): iterable;
}
