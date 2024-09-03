<?php

namespace App\Services\Statistics;

use App\Enums\Mood;
use App\Models\Collection;
use App\Models\Support\MoodBand;
use App\Models\Support\NodeActivity;
use App\Models\Support\NodeEntry;
use App\Models\Support\TableActivity;
use App\Models\Support\TableCollection;

class StatisticsCollector implements StatisticsCollectorInterface
{
    /**
     * @param array<NodeActivity> $nodes
     * @param array<Collection> $collections
     * @return iterable<TableCollection>
     */
    public function forTable(array $nodes, array $collections, int $daysAgo): iterable
    {
        $tableActivities = collect($nodes)
            ->groupBy('name')
            ->map(fn($group) => new TableActivity(
                $group[0]->name,
                $group[0]->icon,
                collect($group)->map(fn($activity) => $activity->date->format('Y-m-d'))->toArray(),
                $group[0]->collectionId,
                $daysAgo
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


    /** @param array<NodeEntry> $nodes */
    public function forMoodBand(array $nodes): MoodBand
    {
        $total = count($nodes);
        $groups = collect($nodes)->groupBy('mood');

        return new MoodBand(
            radiating: $this->toPercents(Mood::RADIATING, $groups, $total),
            happy: $this->toPercents(Mood::HAPPY, $groups, $total),
            neutral: $this->toPercents(Mood::NEUTRAL, $groups, $total),
            bad: $this->toPercents(Mood::BAD, $groups, $total),
            awful: $this->toPercents(Mood::AWFUL, $groups, $total),
        );
    }


    private function toPercents(Mood $mood, iterable $groups, int $total): float
    {
        if ($total == 0) {
            return 0;
        }

        $group = $groups[$mood->value] ?? [];
        return count($group) / $total * 100;
    }


    /** @return iterable<int> */
    public function forMoodChart(array $nodes): iterable
    {
        return collect($nodes)
            ->sortBy(['month', 'day'])
            ->map(fn ($node) => $node->mood)
            ->values()
            ->toArray();
    }
}
