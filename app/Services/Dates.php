<?php

namespace App\Services;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;

class Dates
{
    public static function collect(string $from, string $to, string $fromFormat = 'Y-m-d'): array
    {
        $period = new CarbonPeriod(
            Carbon::createFromFormat($fromFormat, $from),
            new CarbonInterval('P1D'),
            Carbon::createFromFormat($fromFormat, $to)
        );
        
        $dates = [];
        foreach ($period as $date) {
            $dates[] = $date->format('Y-m-d');
        }
        
        return $dates;
    }
    
    
    public static function collectLast(int $days): array {
        $dates = [];
        for ($i = 0; $i < $days; $i++) {
            $dates[] = date('Y-m-d', strtotime("-$i days"));
        }
        
        return $dates;
    }
}