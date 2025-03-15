<?php

namespace App\Models\Support;

class IndexEntry
{
    public readonly int $id;

    public readonly int $mood;

    public readonly int $weather;

    public readonly int $goalsTotal;

    public readonly int $goalsCompleted;

    public readonly string $date;

    public readonly string $diary;

    /** @var string[] $photos */
    public readonly array $photos;


    public function __construct(
        int $id,
        int $mood,
        int $weather,
        int $goalsTotal,
        int $goalsCompleted,
        string $date,
        ?string $diary,
        array $photos,
    ) {
        $this->id = $id;
        $this->mood = $mood;
        $this->weather = $weather;
        $this->goalsTotal = $goalsTotal;
        $this->goalsCompleted = $goalsCompleted;
        $this->date = $date;
        $this->diary = $diary ?? '';
        $this->photos = $photos;
    }
}
