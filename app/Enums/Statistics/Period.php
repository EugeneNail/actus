<?php

namespace App\Enums\Statistics;

enum Period: int
{
    case MONTH = 30;
    case SEASON = 90;
    case YEAR = 365;


    public function toString(): string
    {
        return match ($this) {
            self::MONTH => 'month',
            self::SEASON => 'season',
            self::YEAR => 'year',
        };
    }


    public static function toPeriod(string $name): int {
        return match($name) {
            'month' => self::MONTH->value,
            'season' => self::SEASON->value,
            'year' => self::YEAR->value,
        };
    }
}
