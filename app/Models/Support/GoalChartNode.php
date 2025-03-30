<?php

namespace App\Models\Support;

class GoalChartNode
{
    public int $plain;

    public float $percent;


    public function __construct(int $plain, int $userGoalCount) {
        $this->plain = $plain;
        $this->percent = round($plain / $userGoalCount * 100);
    }
}
