<?php

namespace App\Services\Statistics;

use App\Models\Entry;
use App\Models\Support\NodeEntry;
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
}
