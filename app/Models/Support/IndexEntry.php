<?php

namespace App\Models\Support;

class IndexEntry
{
    public readonly int $id;

    public readonly int $mood;

    public readonly int $weather;

    public readonly int $sleeptime;

    public readonly float $weight;

    public readonly int $worktime;

    public readonly string $date;

    public readonly string $diary;

    /** @var array<string> $photos */
    public readonly array $photos;

    /** @var $collections array<IndexEntryCollection> */
    public readonly array $collections;


    /** @param $collections array<IndexEntryCollection> */
    public function __construct(int $id, int $mood, int $weather, int $sleeptime, float $weight, int $worktime, string $date, ?string $diary, array $photos, array $collections)
    {
        $this->id = $id;
        $this->mood = $mood;
        $this->weather = $weather;
        $this->sleeptime = $sleeptime;
        $this->weight = $weight;
        $this->worktime = $worktime;
        $this->date = $date;
        $this->diary = $diary ?? '';
        $this->photos = $photos;
        $this->collections = $collections;
    }
}
