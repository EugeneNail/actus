<?php

namespace App\Services\Statistics;

use App\Enums\Mood;
use App\Models\Support\MoodBand;

class StatisticsCollector implements StatisticsCollectorInterface
{
    /** @inheritDoc */
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


    private function moodToPercents(Mood $mood, iterable $groups, int $total): float
    {
        if ($total == 0) {
            return 0;
        }

        $group = $groups[$mood->value] ?? [];
        return count($group) / $total * 100;
    }


    /** @inheritDoc */
    public function forMoodChart(array $nodes): iterable
    {
        return collect($nodes)
            ->sortByDesc(['month', 'day'])
            ->map(fn($node) => $node->mood)
            ->values()
            ->toArray();
    }
}
