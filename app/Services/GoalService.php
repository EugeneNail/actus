<?php

namespace App\Services;

use App\Models\Goal;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GoalService
{
    /**
     * @param array $data
     * @return void
     */
    public function create(array $data): void
    {
        $goal = new Goal($data);
        $goal->user()->associate(Auth::user());
        $goal->save();
    }


    public function update(Goal $goal, array $data): void
    {
        $goal->update($data);
    }


    /**
     * Collects goals in period and calculates the number of days between the given date and the latest date when the goal was completed.
     * Default value -1 means "There were no certain goal completions during period"
     * @return array<int, int>
     * @throws Exception
     */
    public function collectLatestGoalCompletions(Carbon $today, int $userId): array
    {
        $goalCompletions = [];
        $startDate = (clone $today)->subMonth();

        $rows = DB::query()
            ->select('id')
            ->from('goals')
            ->where('user_id', $userId)
            ->get();

        foreach ($rows as $row) {
            $goalCompletions[$row->id] = -1;
        }

        $rows = DB::query()
            ->select(['entries_goals.goal_id as goalId', DB::raw('MAX(entries.date) as date')])
            ->join('entries', 'entries.id', '=', 'entries_goals.entry_id')
            ->from('entries_goals')
            ->where('entries.date', '>=', $startDate->format('Y-m-d'))
            ->where('entries.date', '<=', $today->format('Y-m-d'))
            ->where('entries.user_id', $userId)
            ->groupBy('goalId')
            ->get();

        foreach ($rows as $row) {
            $date = new Carbon($row->date);
            $goalCompletions[$row->goalId] = $today->diff($date)->days;
        }

        return $goalCompletions;
    }


    /**
     * Delete the goal from database
     * @param Goal $goal
     * @return void
     */
    public function delete(Goal $goal): void
    {
        $goal->delete();
    }
}
