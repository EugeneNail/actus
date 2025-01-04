<?php

namespace App\Services\Statistics;

use App\Models\Entry;
use App\Models\Support\NodeActivity;
use App\Models\Support\NodeEntry;
use App\Models\User;
use Illuminate\Support\Carbon;

class StatisticsService implements StatisticsServiceInterface
{
    /** @inheritDoc */
    public function getActivityNodes(User $user, int $daysAgo): array
    {
        return $user
            ->entries()
            ->where('date', '>', (new Carbon())->subDays($daysAgo))
            ->get()
            ->map($this->entryToNodeActivities(...))
            ->flatten()
            ->toArray();
    }


    /** @return array<NodeActivity> */
    private function entryToNodeActivities(Entry $entry): array
    {
        $nodes = [];
        foreach ($entry->activities as $activity) {
            $nodes[] = new NodeActivity(
                $activity->name,
                $activity->icon,
                $entry->date,
                $activity->collection_id
            );
        }

        return $nodes;
    }


    /** @return array<NodeEntry> */
    public function getEntryNodes(User $user, int $daysAgo): array
    {
        return $user
            ->entries()
            ->where('date', '>', (new Carbon())->subDays($daysAgo))
            ->get()
            ->map(fn(Entry $entry) => new NodeEntry($entry->mood, $entry->weather, $entry->sleeptime, $entry->weight, $entry->worktime, $entry->date))
            ->toArray();
    }
}
