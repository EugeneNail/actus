<?php

namespace App\Models\Support;

use Carbon\Carbon;

class IndexMonth
{
    public int $entries;

    public int $days;

    public int $month;

    public int $year;


    public function __construct(iterable $entries, Carbon $carbon)
    {
        $this->entries = count($entries);
        $this->days = $carbon->daysInMonth;
        $this->month = $carbon->month;
        $this->year = $carbon->year;
    }
}
