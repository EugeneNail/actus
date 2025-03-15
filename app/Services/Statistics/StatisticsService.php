<?php

namespace App\Services\Statistics;

use App\Models\Entry;
use App\Models\Support\NodeEntry;
use App\Models\Support\NodeGoal;
use App\Models\User;
use Illuminate\Support\Carbon;

class StatisticsService implements StatisticsServiceInterface
{
    /** @return array<NodeEntry> */
    public function getEntryNodes(User $user, int $daysAgo): array
    {
        return $user
            ->entries()
            ->where('date', '>', (new Carbon())->subDays($daysAgo))
            ->get()
            ->map(fn(Entry $entry) => new NodeEntry($entry->mood, $entry->weather, $entry->date))
            ->toArray();
    }


    public function getGoalNodes(User $user, int $daysAgo): array
    {
        $entries = $user
            ->entries()
            ->with('goals')
            ->where('date', '>', (new Carbon())->subDays($daysAgo))
            ->get();

        $nodes = [];

        foreach ($entries as $entry) {
            foreach ($entry->goals as $goal) {
                $nodes[] = new NodeGoal($goal->id, $entry->date);
            }
        }

        return $nodes;
    }
}
