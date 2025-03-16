<?php

namespace App\Models\Support;

use App\Models\Goal;

class IndexEntry
{
    public readonly int $id;

    public readonly int $mood;

    public readonly int $weather;

    public readonly int $goalsTotal;

    /** @var Goal[] $goals*/
    public readonly iterable $goals;

    public readonly string $date;

    public readonly string $diary;

    /** @var string[] $photos */
    public readonly array $photos;


    public function __construct(
        int $id,
        int $mood,
        int $weather,
        int $goalsTotal,
        iterable $goals,
        string $date,
        ?string $diary,
        array $photos,
    ) {
        $this->id = $id;
        $this->mood = $mood;
        $this->weather = $weather;
        $this->goalsTotal = $goalsTotal;
        $this->goals = $goals;
        $this->date = $date;
        $this->diary = $diary ?? '';
        $this->photos = $photos;
    }
}
