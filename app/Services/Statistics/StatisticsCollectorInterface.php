<?php

namespace App\Services\Statistics;

use App\Models\Collection;
use App\Models\Support\FrequentActivity;
use App\Models\Support\MoodBand;
use App\Models\Support\NodeActivity;
use App\Models\Support\NodeEntry;
use App\Models\Support\TableCollection;

interface StatisticsCollectorInterface
{
    /**
     * @param NodeActivity[] $nodes
     * @param Collection[] $collections
     * @return iterable<TableCollection>
     */
    public function forTable(array $nodes, array $collections, int $daysAgo): iterable;


    /** @param NodeEntry[] $nodes */
    public function forMoodBand(array $nodes): MoodBand;


    /**
     * @param NodeEntry[] $nodes
     * @return iterable<int>
     */
    public function forMoodChart(array $nodes): iterable;


    /**
     * @param NodeActivity[] $nodes
     * @return iterable<FrequentActivity>
     */
    public function forFrequency(array $nodes, int $limit): iterable;


    /**
     * @param NodeEntry[] $nodes
     * @return float[]
     */
    public function forWeightChart(array $nodes): iterable;


    /**
     * @param NodeEntry[] $nodes
     * @return float[]
     */
    public function forSleeptimeChart(array $nodes): iterable;


    /**
     * @param NodeEntry[] $nodes
     * @return float[]
     */
    public function forWorktimeChart(array $nodes): iterable;
}
