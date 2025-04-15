<?php

namespace App\Enums;

enum Weather: int
{
    case HEAT = 1;
    case SUNNY = 2;
    case CLOUDY = 3;
    case WINDY = 4;
    case RAINY = 5;
    case THUNDER = 6;
    case FOG = 7;
    case SNOWING = 8;
    case COLD = 9;


    public function toString(): string
    {
        return match ($this) {
            self::HEAT => 'Heat',
            self::SUNNY => 'Sunny',
            self::CLOUDY => 'Cloudy',
            self::WINDY => 'Windy',
            self::RAINY => 'Rainy',
            self::THUNDER => 'Thunder',
            self::FOG => 'Fog',
            self::SNOWING => 'Snowing',
            self::COLD => 'Cold'
        };
    }
}
