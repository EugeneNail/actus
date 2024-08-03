<?php

namespace App\Models\Support;

class TableCollection
{
    public int $id;

    public string $name;

    public int $color;

    /** @var array<TableActivity> $activities*/
    public array $activities;


    public function __construct(int $id, int $color, string $name, array $activities) {
        $this->id = $id;
        $this->name = $name;
        $this->color = $color;
        $this->activities = $activities;
    }
}
