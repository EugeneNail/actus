<?php

namespace App\Services\Statistics;

use App\Enums\Mood;
use App\Models\Support\MoodBand;
use App\Models\Support\NodeEntry;
use App\Models\Support\TableActivity;
use App\Models\Support\TableCollection;
use DateInterval;
use DatePeriod;
use DateTime;
use Exception;

class StatisticsCollector implements StatisticsCollectorInterface
{
    /** @inheritDoc */
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


    /** @inheritDoc */
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


    /** @inheritDoc */
    public function forMoodChart(array $nodes): iterable
    {
        return collect($nodes)
            ->sortByDesc(['month', 'day'])
            ->map(fn($node) => $node->mood)
            ->values()
            ->toArray();
    }


    /** @inheritDoc */
    public function forFrequency(array $nodes, int $limit): iterable
    {
        $countedNodes = [];

        foreach ($nodes as $node) {
            $index = $node->name . $node->collectionId;

            if (!isset($countedNodes[$index])) {
                $countedNodes[$index] = [
                    'node' => $node,
                    'count' => 0
                ];
            }

            $countedNodes[$index]['count']++;
        }

        return collect($countedNodes)
            ->sortByDesc(fn($countedNode) => $countedNode['count'])
            ->take($limit)
            ->map(fn($countedNode) => [
                'name' => $countedNode['node']->name,
                'icon' => $countedNode['node']->icon,
                'count' => $countedNode['count']
            ])
            ->values();
    }


    /**
     * @inheritDoc
     * @throws Exception
     */
    public function forWeightChart(array $nodes): iterable
    {
        $nodes = collect($nodes)
            ->keyBy($this->nodeToDate(...))
            ->sortByDesc(fn($_, $key) => $key)
            ->map(fn($entry) => $entry->weight)
            ->toArray();

        $weights = [];
        $period = $this->createMonthPeriod();

        foreach ($period as $date) {
            $date = $date->format('Y-m-d');
            $weights[] = $nodes[$date] ?? -1;
        }

        return array_reverse($weights);
    }


    /**
     * @inheritDoc
     * @throws Exception
     */
    public function forSleeptimeChart(array $nodes): iterable
    {
        $nodes = collect($nodes)
            ->keyBy($this->nodeToDate(...))
            ->sortByDesc(fn($_, $key) => $key)
            ->map(fn($entry) => $entry->sleeptime)
            ->toArray();
        $sleeptimes = [];

        $period = $this->createMonthPeriod();
        foreach ($period as $date) {
            $date = $date->format('Y-m-d');
            $sleeptimes[] = $nodes[$date] ?? -1;
        }

        return array_reverse($sleeptimes);
    }


    /**
     * @inheritDoc
     * @throws Exception
     */
    public function forWorktimeChart(array $nodes): iterable
    {
        $nodes = collect($nodes)
            ->keyBy($this->nodeToDate(...))
            ->sortByDesc(fn($_, $key) => $key)
            ->map(fn($entry) => $entry->worktime)
            ->toArray();

        $sleeptimes = [];

        $period = $this->createMonthPeriod();
        foreach ($period as $date) {
            $date = $date->format('Y-m-d');
            $sleeptimes[] = $nodes[$date] ?? -1;
        }

        return array_reverse($sleeptimes);
    }


    private function nodeToDate(NodeEntry $entry): string {
        return sprintf(
            '%d-%s-%s',
            $entry->year,
            str_pad($entry->month, 2, '0', STR_PAD_LEFT),
            str_pad($entry->day, 2, '0', STR_PAD_LEFT)
        );
    }


    /**
     * @throws Exception
     */
    private function createMonthPeriod(): DatePeriod
    {
        return new DatePeriod(
            new DateTime(date('Y-m-d', time() - 60 * 60 * 24 * 30)),
            new DateInterval('P1D'),
            (new DateTime(date('Y-m-d')))->setTime(0, 0, 1)
        );
    }
}
