<?php

namespace App\Services\Statistics;

use App\Models\Collection;
use App\Models\Support\NodeActivity;
use App\Models\Support\TableActivity;
use App\Models\Support\TableCollection;

class StatisticsCollector implements StatisticsCollectorInterface
{
    /**
     * @param array<NodeActivity> $nodes
     * @param array<Collection> $collections
     * @return array<TableCollection>
     * */
    public function forTable(array $nodes, array $collections): iterable
    {
        $tableActivities = collect($nodes)
            ->groupBy('name')
            ->map(fn($group) => new TableActivity(
                $group[0]->name,
                $group[0]->icon,
                collect($group)->map(fn($activity) => $activity->date->format('Y-m-d'))->toArray(),
                $group[0]->collectionId,
            ))
            ->flatten();

        $tableCollections = collect($collections)
            ->map(fn($collection) => new TableCollection(
                $collection['id'],
                $collection['color'],
                $collection['name'],
                [],
            ))
            ->keyBy('id');

        foreach ($tableActivities as $activity) {
            $tableCollections[$activity->collectionId]->activities[] = $activity;
        }

        return $tableCollections->values();
    }
}
