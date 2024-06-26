<?php

namespace App\Models\Support;

class IndexEntryCollection
{
    public readonly string $name;

    public readonly int $color;

    /** @var array<IndexEntryActivity>*/
    public array $activities;

    public function __construct(string $name, int $color) {
        $this->name = $name;
        $this->color = $color;
    }
}
