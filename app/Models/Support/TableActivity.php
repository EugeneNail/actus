<?php

namespace App\Models\Support;

use Carbon\Carbon;

class TableActivity
{
    public string $name;

    public int $icon;

    /** @var array<bool> */
    public array $lastOccurrences;

    public int $collectionId;


    public function __construct(string $name, int $icon, array $recordedDates, int $collectionId, int $numberOfDates = 15)
    {
        $this->name = $name;
        $this->icon = $icon;
        $this->collectionId = $collectionId;

        $date = new Carbon();
        for ($i = 0; $i < $numberOfDates; $i++) {
            $this->lastOccurrences[] = in_array($date->format('Y-m-d'), $recordedDates);
            $date->subDay();
        }
    }
}
