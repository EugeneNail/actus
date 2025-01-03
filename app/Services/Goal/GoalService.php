<?php

namespace App\Services\Goal;

use App\Models\Goal;
use Auth;

class GoalService implements GoalServiceInterface
{

    public function store(array $data): void
    {
        $goal = new Goal($data);
        $goal->user()->associate(Auth::user());
        $goal->save();
    }


    public function update(Goal $goal, array $data): void
    {
        $goal->update($data);
    }
}
