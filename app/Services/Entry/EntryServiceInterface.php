<?php

namespace App\Services\Entry;

use App\Models\Entry;
use App\Models\Support\IndexEntry;
use App\Models\Support\IndexMonth;
use App\Models\User;

interface EntryServiceInterface
{
    /** @return array<IndexEntry> */
    public function collectForIndex(int $month, int $year): array;

    /** @return  array<IndexMonth>*/
    public function collectMonthData(User $user): iterable;

    public function create(array $data, int $userId): Entry;

    public function update(Entry $entry, array $data): Entry;

    /** @param $activityIds array<int> */
    public function saveActivities(Entry $entry, array $activityIds): void;

    /** @param $goalsIds array<int> */
    public function saveGoals(Entry $entry, array $goalsIds): void;

    /** @param $photoNames array<string> */
    public function savePhotos(Entry $entry, array $photoNames): void;

    /** @param string $date in format YYYY-mm-dd */
    public function existsForDate(string $date, int $userId): bool;
}
