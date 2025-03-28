<?php

namespace App\Services\Statistics;

use App\Enums\Mood;
use App\Models\Goal;
use App\Models\Support\MoodBand;
use App\Models\Support\NodeEntry;
use App\Models\Support\NodeGoal;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DateTime;
use Illuminate\Support\Facades\Auth;

class StatisticsCollector
{
    /**
     * Collects and calculates mood percentage distribution
     * @param NodeEntry[] $nodes
     * @return MoodBand
     */
    public function forMoodBand(array $nodes): MoodBand
    {
        $total = count($nodes);
        $groups = collect($nodes)->groupBy('mood');

        return new MoodBand(
            radiating: $this->moodToPercents(Mood::RADIATING, $groups, $total),
            happy: $this->moodToPercents(Mood::HAPPY, $groups, $total),
            neutral: $this->moodToPercents(Mood::NEUTRAL, $groups, $total),
            bad: $this->moodToPercents(Mood::BAD, $groups, $total),
            awful: $this->moodToPercents(Mood::AWFUL, $groups, $total),
        );
    }


    /**
     * Calculates percentage from plain values
     * @param Mood $mood
     * @param iterable $groups
     * @param int $total
     * @return float
     */
    private function moodToPercents(Mood $mood, iterable $groups, int $total): float
    {
        if ($total == 0) {
            return 0;
        }

        $group = $groups[$mood->value] ?? [];
        return count($group) / $total * 100;
    }


    /**
     * Extracts only mood values
     * @param NodeEntry[] $nodes
     * @return iterable<int>
     */
    public function forMoodChart(array $nodes): iterable
    {
        return collect($nodes)
            ->sortByDesc(['month', 'day'])
            ->map(fn($node) => $node->mood)
            ->values()
            ->toArray();
    }


    /**
     * Determines for each date whether the goal has been completed.
     * If there is no value for a date, sets it to FALSE
     * @param NodeGoal[] $nodes
     * @param int $daysAgo
     * @return iterable
     */
    public function forGoalHeatmap(array $nodes, int $daysAgo): iterable
    {
        $heatmap = [];

        /** @var Goal[] $goals */
        $goals = Auth::user()->goals->keyBy('id');

        $indexed = [];
        foreach ($nodes as $node) {
            $date = (new DateTime())->setDate($node->year, $node->month, $node->day)->format('Y-m-d');
            $indexed[$date][$node->id] = $node->id;
        }

        $start = (new Carbon())->subDays($daysAgo)->format('Y-m-d');
        $period = new CarbonPeriod($start, '1 days', date('Y-m-d'));

        foreach ($goals as $goal) {
            $heatmap[$goal->id] = [
                'icon' => $goal->icon,
                'heat' => []
            ];

            foreach ($period as $date) {
                $date = $date->format('Y-m-d');
                $heatmap[$goal->id]['heat'][] = isset($indexed[$date][$goal->id]);
            }

            $heatmap[$goal->id]['heat'] = array_reverse($heatmap[$goal->id]['heat']);
        }

        return array_values($heatmap);
    }
}
