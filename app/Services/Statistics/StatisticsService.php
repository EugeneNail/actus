<?php

namespace App\Services\Statistics;

use App\Models\Entry;
use App\Models\Support\NodeActivity;
use App\Models\User;
use Illuminate\Support\Carbon;
use InvalidArgumentException;

class StatisticsService implements StatisticsServiceInterface
{
    /** @return array<NodeActivity> */
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
}
