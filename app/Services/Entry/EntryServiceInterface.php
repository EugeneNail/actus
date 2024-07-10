<?php

namespace App\Services\Entry;

use App\Models\Entry;
use App\Models\Support\IndexEntry;

interface EntryServiceInterface
{
    /**@return array<IndexEntry>*/
    public function collectForIndex(int $month, int $year): array;

    public function create(array $data, int $userId): Entry;

    public function update(Entry $entry, array $data): Entry;

    /** @param $activityIds array<int> */
    public function saveActivities(Entry $entry, array $activityIds): void;

    /** @param $photoNames array<string> */
    public function savePhotos(Entry $entry, array $photoNames): void;

    /** @param string $date in format YYYY-mm-dd */
    public function existsForDate(string $date, int $userId): bool;
}
