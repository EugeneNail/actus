<?php

namespace App\Models\Support;

class IndexEntry
{
    public readonly int $id;

    public readonly int $mood;

    public readonly int $weather;

    public readonly string $date;

    public readonly string $diary;

    /** @var $collections array<IndexEntryCollection>*/
    public readonly array $collections;


    /** @param $collections array<IndexEntryCollection>*/
    public function __construct(int $id, int $mood, int $weather, string $date, ?string $diary, array $collections) {
        $this->id = $id;
        $this->mood = $mood;
        $this->weather = $weather;
        $this->date = $date;
        $this->diary = $diary ?? '';
        $this->collections = $collections;
    }
}
