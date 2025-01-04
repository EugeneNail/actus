<?php

namespace App\Models\Support;

class IndexEntryActivity
{
    public readonly string $name;

    public readonly int $icon;


    public function __construct(string $name, int $icon)
    {
        $this->name = $name;
        $this->icon = $icon;
    }
}
