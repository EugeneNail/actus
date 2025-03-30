<?php

namespace App\Services\Statistics;

use App\Enums\Mood;
use App\Enums\StatisticsPeriod;
use App\Models\Entry;
use App\Models\Goal;
use App\Models\Support\GoalChartNode;
use App\Models\Support\MoodBand;
use App\Models\Support\NodeEntry;
use App\Models\Support\NodeGoal;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DatePeriod;
use DateTime;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class StatisticsCollector
{
    /**
     * Collects and calculates mood percentage distribution
     * @param string[] $dates
     * @param Collection|Entry[] $entries
     * @return MoodBand
     */
    public function forMoodBand(array $dates, Collection $entries): MoodBand
    {
        $entries = $entries->mapWithKeys(fn (Entry $entry) => [$entry->date->format('Y-m-d') => $entry->mood]);

        $total = count($dates);
        $occurrences = [
            Mood::RADIATING->value => 0,
            Mood::HAPPY->value => 0,
            Mood::NEUTRAL->value => 0,
            Mood::BAD->value => 0,
            Mood::AWFUL->value => 0,
        ];
        
        foreach($dates as $date) {
            $mood = $entries[$date] ?? 1;

            if (!isset($occurrences[$mood])) {
                $occurrences[$mood] = 0;
            }

            $occurrences[$mood] += 1;
        }

        return new MoodBand(
            radiating: $this->moodToPercents(Mood::RADIATING, $occurrences, $total),
            happy: $this->moodToPercents(Mood::HAPPY, $occurrences, $total),
            neutral: $this->moodToPercents(Mood::NEUTRAL, $occurrences, $total),
            bad: $this->moodToPercents(Mood::BAD, $occurrences, $total),
            awful: $this->moodToPercents(Mood::AWFUL, $occurrences, $total),
        );
    }


    /**
     * Calculates percentage from plain values
     * @param Mood $mood
     * @param int[] $occurrences
     * @param int $total
     * @return float
     */
    private function moodToPercents(Mood $mood, array $occurrences, int $total): float
    {
        if ($total == 0) {
            return 0;
        }

        return round($occurrences[$mood->value] / $total * 100);
    }


    /**
     * Collects moods for each entry
     * @param string[] $dates
     * @param Collection|Entry[] $entries
     * @return int[]
     */
    public function forMoodChart(array $dates, Collection $entries): iterable
    {
        $entries = $entries->mapWithKeys(fn (Entry $entry) => [$entry->date->format('Y-m-d') => $entry->mood]);

        $moodChart = [];
        foreach ($dates as $date) {
            $moodChart[] = $entries[$date] ?? 1;
        }

        return $moodChart;
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


    /**
     * Collects completed goal count in percents for each entry
     * @param string[] $dates
     * @param Collection|Entry[] $entries
     * @param int $userGoalCount
     * @return int[]
     */
    public function forGoalChart(array $dates, Collection $entries, int $userGoalCount): array {
        $entries = $entries->mapWithKeys(fn (Entry $entry) => [$entry->date->format('Y-m-d') => $entry->goals->count()]);
        $goalChart = [];

        foreach ($dates as $date) {
            $goalChart[] = new GoalChartNode($entries[$date] ?? 0, $userGoalCount);
        }

        return $goalChart;
    }
}
