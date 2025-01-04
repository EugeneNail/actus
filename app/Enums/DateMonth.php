<?php

namespace App\Enums;

enum DateMonth: int
{
    case JANUARY = 1;
    case FEBRUARY = 2;
    case MARCH = 3;
    case APRIL = 4;
    case MAY = 5;
    case JUNE = 6;
    case JULY = 7;
    case AUGUST = 8;
    case SEPTEMBER = 9;
    case OCTOBER = 10;
    case NOVEMBER = 11;
    case DECEMBER = 12;


    public function toString(): string
    {
        return match ($this) {
            self::JANUARY => 'Января',
            self::FEBRUARY => 'Февраля',
            self::MARCH => 'Марта',
            self::APRIL => 'Апреля',
            self::MAY => 'Мая',
            self::JUNE => 'Июня',
            self::JULY => 'Июля',
            self::AUGUST => 'Августа',
            self::SEPTEMBER => 'Сентября',
            self::OCTOBER => 'Октября',
            self::NOVEMBER => 'Ноября',
            self::DECEMBER => 'Декабря',
        };
    }
}
