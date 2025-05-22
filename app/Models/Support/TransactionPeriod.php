<?php

namespace App\Models\Support;

use Carbon\Carbon;

class TransactionPeriod
{
    public const FORMAT = 'd/m/Y';

    public string $from;

    public string $to;


    public function __construct(Carbon $from, Carbon $to)
    {
        $this->from = $from->format(static::FORMAT);
        $this->to = $to->format(static::FORMAT);
    }
}
