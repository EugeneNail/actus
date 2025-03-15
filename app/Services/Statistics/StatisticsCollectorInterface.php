<?php

namespace App\Services\Statistics;

use App\Models\Support\MoodBand;
use App\Models\Support\NodeEntry;

interface StatisticsCollectorInterface
{
    /** @param NodeEntry[] $nodes */
    public function forMoodBand(array $nodes): MoodBand;


    /**
     * @param NodeEntry[] $nodes
     * @return iterable<int>
     */
    public function forMoodChart(array $nodes): iterable;
}
