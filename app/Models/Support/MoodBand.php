<?php

namespace App\Models\Support;

class MoodBand
{
    public float $radiating;

    public float $happy;

    public float $neutral;

    public float $bad;

    public float $awful;


    public function __construct(float $radiating, float $happy, float $neutral, float $bad, float $awful)
    {
        $this->radiating = $radiating;
        $this->happy = $happy;
        $this->neutral = $neutral;
        $this->bad = $bad;
        $this->awful = $awful;
    }

}
