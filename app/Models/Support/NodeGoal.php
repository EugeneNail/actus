<?php

namespace App\Models\Support;

use \Carbon\Carbon;

class NodeGoal
{
    public int $id;

    public int $day;

    public int $month;

    public int $year;


    public function __construct(int $id, Carbon $carbon)
    {
        $this->id = $id;
        $this->day = $carbon->day;
        $this->month = $carbon->month;
        $this->year = $carbon->year;
    }
}
