<?php

namespace App\Models\Support\Transaction;

use Carbon\Carbon;

class Period
{
    public const FORMAT = 'Y-m-d';

    public string $from;

    public string $to;


    public function __construct(Carbon $from, Carbon $to)
    {
        $this->from = $from->format(static::FORMAT);
        $this->to = $to->format(static::FORMAT);
    }
}
