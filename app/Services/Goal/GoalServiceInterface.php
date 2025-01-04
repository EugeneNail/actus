<?php

namespace App\Services\Goal;

use App\Models\Goal;

interface GoalServiceInterface
{
    public function store(array $data): void;

    public function update(Goal $goal, array $data): void;

    /** @return array<int, int> */
    public function collectGoalCompletions(int $userId): array;
}
