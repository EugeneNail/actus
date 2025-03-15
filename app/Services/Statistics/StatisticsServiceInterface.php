<?php

namespace App\Services\Statistics;

use App\Models\Support\NodeEntry;
use App\Models\Support\NodeGoal;
use App\Models\User;

interface StatisticsServiceInterface
{
    /** @return NodeEntry[] */
    public function getEntryNodes(User $user, int $daysAgo): array;

    /** @return NodeGoal[] */
    public function getGoalNodes(User $user, int $daysAgo): array;
}
