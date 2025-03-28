<?php

namespace App\Services\Statistics;

use App\Models\Entry;
use App\Models\Support\NodeEntry;
use App\Models\Support\NodeGoal;
use App\Models\User;
use Illuminate\Support\Carbon;

class NodeCollector
{
    /**
     * Collects and maps entries to NodeEntry array
     * @param User $user
     * @param int $daysAgo
     * @return NodeEntry[]
     */
    public function collectEntryNodes(User $user, int $daysAgo): array
    {
        return $user
            ->entries()
            ->where('date', '>', (new Carbon())->subDays($daysAgo))
            ->get()
            ->map(fn(Entry $entry) => new NodeEntry($entry->mood, $entry->weather, $entry->date))
            ->toArray();
    }


    /**
     * Collects and maps goals to NodeGoal array
     * @param User $user
     * @param int $daysAgo
     * @return NodeGoal[]
     */
    public function collectGoalNodes(User $user, int $daysAgo): array
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
