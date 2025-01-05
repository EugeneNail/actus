<?php

namespace App\Services\Goal;

use App\Models\Goal;
use Carbon\Carbon;

interface GoalServiceInterface
{
    public function store(array $data): void;

    public function update(Goal $goal, array $data): void;

    /** @return array<int, int> */
    public function collectGoalCompletions(Carbon $today, int $userId): array;

    public function destroy(Goal $goal): void;
}
