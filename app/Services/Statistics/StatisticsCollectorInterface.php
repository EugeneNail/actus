<?php

namespace App\Services\Statistics;

use App\Models\Collection;
use App\Models\Support\NodeActivity;
use App\Models\Support\TableCollection;

interface StatisticsCollectorInterface
{
    /**
     * @param array<NodeActivity> $nodes
     * @param array<Collection> $collections
     * @return array<TableCollection>
     * */
    public function forTable(array $nodes, array $collections): iterable;
}
