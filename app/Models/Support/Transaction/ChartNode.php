<?php

namespace App\Models\Support\Transaction;

class ChartNode
{
    public readonly float $value;
    
    public readonly string $date;
    
    public float $percent;
    
    
    public function __construct(string $date, float $value)
    {
        $this->date = $date;
        $this->value = $value;
    }
}