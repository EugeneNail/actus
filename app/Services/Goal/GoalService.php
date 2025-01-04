<?php

namespace App\Services\Goal;

use App\Models\Goal;
use Exception;
use Illuminate\Support\Facades\Auth;
use DateTime;
use Illuminate\Support\Facades\DB;

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


    /**
     * @inheritDoc
     * @throws Exception
     */
    public function collectGoalCompletions(int $userId): array
    {
        $goalCompletions = [];

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
            ->where('entries.date', '<=', date('Y-m-d', strtotime('-30 days')))
            ->groupBy('goalId')
            ->get();

        $today = new DateTime(date('Y-m-d'));

        foreach ($rows as $row) {
            $date = new DateTime($row->date);

            $goalCompletions[$row->goalId] = $today->diff($date)->days;
        }

        return $goalCompletions;
    }
}
