<?php

namespace service;

use App\Models\Support\IndexEntry;

interface EntryServiceInterface
{
    /**@return array<IndexEntry>*/
    public function collectForIndex(int $month, int $year): array;
}
