<?php

namespace App\Services\Statistics;

use App\Models\Support\NodeEntry;
use App\Models\User;

interface StatisticsServiceInterface
{
    /** @return array<NodeEntry> */
    public function getEntryNodes(User $user, int $daysAgo): array;
}
