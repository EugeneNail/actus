<?php

namespace App\Models\Support\Transaction;

use InvalidArgumentException;

class CashFlow
{
    public readonly float $income;
    
    public readonly float $outcome;
    
    public readonly float $summary;
    
    
    public function __construct(float $income, float $outcome)
    {
        if ($income < 0) {
            throw new InvalidArgumentException('$income must be positive');
        }
        
        if ($outcome > 0) {
            throw new InvalidArgumentException('$income must be negative');
        }
        
        $this->income = $income;
        $this->outcome = $outcome;
        $this->summary = $income + $outcome;
    }
}