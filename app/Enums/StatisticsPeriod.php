<?php

namespace App\Enums;

enum StatisticsPeriod: int
{
    case MONTH = 30;
    case YEAR = 365;


    public function toString(): string
    {
        return match ($this) {
            self::MONTH => 'month',
            self::YEAR => 'year',
        };
    }
}
