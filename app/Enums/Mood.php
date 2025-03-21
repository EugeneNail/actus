<?php

namespace App\Enums;

enum Mood: int
{
    case AWFUL = 1;
    case BAD = 2;
    case NEUTRAL = 3;
    case HAPPY = 4;
    case RADIATING = 5;


    public function toString(): string
    {
        return match ($this) {
            self::AWFUL => 'Ужасное',
            self::BAD => 'Плохое',
            self::NEUTRAL => 'Никакое',
            self::HAPPY => 'Хорошее',
            self::RADIATING => 'Отличное',
        };
    }
}
