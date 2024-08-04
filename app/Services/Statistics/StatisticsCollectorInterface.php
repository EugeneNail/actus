<?php

namespace App\Services\Statistics;

use App\Models\Collection;
use App\Models\Support\MoodBand;
use App\Models\Support\NodeActivity;
use App\Models\Support\NodeEntry;
use App\Models\Support\TableCollection;

interface StatisticsCollectorInterface
{
    /**
     * @param array<NodeActivity> $nodes
     * @param array<Collection> $collections
     * @return array<TableCollection>
     * */
    public function forTable(array $nodes, array $collections, int $daysAgo): iterable;


    /** @param array<NodeEntry> $nodes */
    public function forMoodBand(array $nodes, int $daysAgo): MoodBand;
}
