<?php

namespace App\Models\Support;

use Illuminate\Support\Carbon;

class NodeEntry
{
    public int $mood;

    public int $weather;

    public int $sleeptime;

    public float $weight;

    public int $worktime;

    public int $day;

    public int $month;

    public int $year;


    public function __construct(int $mood, int $weather, int $sleeptime, float $weight, int $worktime, Carbon $carbon) {
        $this->mood = $mood;
        $this->weather = $weather;
        $this->sleeptime = $sleeptime;
        $this->weight = $weight;
        $this->worktime = $worktime;
        $this->day = $carbon->day;
        $this->month = $carbon->month;
        $this->year = $carbon->year;
    }
}
