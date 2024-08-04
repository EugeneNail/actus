<?php

namespace App\Services\Statistics;

use App\Models\Support\NodeActivity;
use App\Models\User;

interface StatisticsServiceInterface
{
    /** @return array<NodeActivity>  */
    public function getActivityNodes(User $user, int $daysAgo): array;
}
