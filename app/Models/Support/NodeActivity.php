<?php

namespace App\Models\Support;

use Carbon\Carbon;

class NodeActivity
{
    public string $name;

    public int $icon;

    public Carbon $date;

    public int $collectionId;


    public function __construct(string $name, int $icon, Carbon $date, int $collectionId)
    {
        $this->name = $name;
        $this->icon = $icon;
        $this->date = $date;
        $this->collectionId = $collectionId;
    }
}
