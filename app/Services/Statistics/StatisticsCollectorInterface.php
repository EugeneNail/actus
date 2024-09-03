<?php

namespace App\Services\Statistics;

use App\Models\Collection;
use App\Models\Support\MoodBand;
use App\Models\Support\MoodChartNode;
use App\Models\Support\NodeActivity;
use App\Models\Support\NodeEntry;
use App\Models\Support\TableCollection;

interface StatisticsCollectorInterface
{
    /**
     * @param array<NodeActivity> $nodes
     * @param array<Collection> $collections
     * @return iterable<TableCollection>
     */
    public function forTable(array $nodes, array $collections, int $daysAgo): iterable;


    /** @param array<NodeEntry> $nodes */
    public function forMoodBand(array $nodes): MoodBand;

    /** @return iterable<int>*/
    public function forMoodChart(array $nodes): iterable;
}
