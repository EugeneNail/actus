<?php

namespace App\Models\Support;

use Illuminate\Support\Carbon;

class NodeEntry
{
    public int $mood;

    public int $weather;

    public int $day;

    public int $month;

    public int $year;


    public function __construct(int $mood, int $weather, Carbon $carbon) {
        $this->mood = $mood;
        $this->weather = $weather;
        $this->day = $carbon->day;
        $this->month = $carbon->month;
        $this->year = $carbon->year;
    }
}
