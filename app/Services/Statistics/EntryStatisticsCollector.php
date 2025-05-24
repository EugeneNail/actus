<?php

namespace App\Services\Statistics;

use App\Enums\Mood;
use App\Models\Entry;
use App\Models\Goal;
use App\Models\Support\Goal\ChartNode;
use App\Models\Support\MoodBand;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class EntryStatisticsCollector
{
    /**
     * Collects and calculates mood percentage distribution
     * @param string[] $dates
     * @param Collection|Entry[] $entries
     * @return MoodBand
     */
    public function forMoodBand(array $dates, Collection $entries): MoodBand
    {
        $entries = $entries->mapWithKeys(fn(Entry $entry) => [$entry->date->format('Y-m-d') => $entry->mood]);

        $total = count($dates);
        $occurrences = [
            Mood::RADIATING->value => 0,
            Mood::HAPPY->value => 0,
            Mood::NEUTRAL->value => 0,
            Mood::BAD->value => 0,
            Mood::AWFUL->value => 0,
        ];

        foreach ($dates as $date) {
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
        $entries = $entries->mapWithKeys(fn(Entry $entry) => [$entry->date->format('Y-m-d') => $entry->mood]);

        $moodChart = [];
        foreach ($dates as $date) {
            $moodChart[] = $entries[$date] ?? 1;
        }

        return $moodChart;
    }


    /**
     * Determines for each date whether the goal has been completed.
     * If there is no value for a date, sets it to FALSE
     * @param array $dates
     * @param Collection|Goal[] $userGoals
     * @return iterable
     */
    public function forGoalHeatmap(array $dates, Collection $completedGoals): iterable
    {
        $heatmap = [];
        /** @var Goal[] $userGoals */
        $userGoals = Auth::user()->goals->keyBy('id');

        $completedGoals = $completedGoals->mapWithKeys(fn(Entry $entry) => [$entry->date->format('Y-m-d') => $entry->goals->keyBy('id')->toArray()]);

        foreach ($userGoals as $goal) {
            $heatmap[$goal->id] = [
                'icon' => $goal->icon,
                'heat' => []
            ];

            foreach ($dates as $date) {
                $heatmap[$goal->id]['heat'][] = isset($completedGoals[$date][$goal->id]);
            }
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
    public function forGoalChart(array $dates, Collection $entries, int $userGoalCount): array
    {
        $entries = $entries->mapWithKeys(fn(Entry $entry) => [$entry->date->format('Y-m-d') => $entry->goals->count()]);
        $goalChart = [];

        foreach ($dates as $date) {
            $goalChart[] = new ChartNode($entries[$date] ?? 0, $userGoalCount);
        }

        return $goalChart;
    }


    /**
     * @param array $dates
     * @param Collection|Entry[] $entries
     * @param Collection|Goal[] $userGoals
     * @return array
     */
    public function forGoalCompletion(array $dates, Collection $entries, Collection $userGoals): iterable
    {
        $datesCount = count($dates);
        $goalCompletion = [];
        $entries = $entries->mapWithKeys(fn(Entry $entry) => [
            $entry->date->format('Y-m-d') => $entry->goals->keyBy('id'),
        ]);

        foreach ($userGoals as $goal) {
            $goalCompletion[$goal->id] = [
                'icon' => $goal->icon,
                'completionRate' => 0
            ];

            $occurrences = 0;
            foreach ($dates as $date) {
                if (isset($entries[$date][$goal->id])) {
                    $occurrences++;
                }
            }

            $goalCompletion[$goal->id]['completionRate'] = round($occurrences / $datesCount * 100);
        }

        return collect($goalCompletion)->sortByDesc(fn($item) => $item['completionRate'])->values();
    }
}
