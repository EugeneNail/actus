<?php

namespace App\Services\Statistics;

use App\Models\Support\NodeActivity;
use App\Models\User;

interface StatisticsServiceInterface
{
    /** @return array<NodeActivity>  */
    public function getNodes(User $user, int $daysAgo): array;
}
