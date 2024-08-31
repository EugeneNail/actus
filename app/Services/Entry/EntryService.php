<?php

namespace App\Services\Entry;

use App\Models\Activity;
use App\Models\Collection;
use App\Models\Entry;
use App\Models\Support\IndexEntry;
use App\Models\Support\IndexEntryActivity;
use App\Models\Support\IndexEntryCollection;
use App\Models\Support\IndexMonth;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EntryService implements EntryServiceInterface
{
    public function collectForIndex(?int $month, ?int $year): array
    {
        $month = $month ?? date('m');
        $year = $year ?? date('Y');
        $startDate = "$year-$month-01";
        $endDate = sprintf(
            '%s-%s-%s',
            $year,
            $month,
            date('t', strtotime($startDate))
        );


        $user = Auth::user();
        $collectionsById = $user->collections->keyBy('id');

        return $user
            ->entries()
            ->with(['activities', 'photos'])
            ->where('date', '>=', $startDate)
            ->where('date', '<=', $endDate)
            ->orderByDesc('date')
            ->get()
            ->map(fn($entry) => new IndexEntry(
                $entry->id,
                $entry->mood,
                $entry->weather,
                $entry->date,
                $entry->diary,
                $entry->photos->map(fn($photo) => $photo->name)->toArray(),
                $this->groupActivitiesByCollection($entry->activities, $collectionsById),
            ))
            ->toArray();
    }


    /**
     * @param $activities array<Activity>
     * @param $collectionsById array<int, Collection>
     * @return array<IndexEntryCollection>
     */
    private function groupActivitiesByCollection(iterable $activities, iterable $collectionsById): array
    {
        $collectionsMap = [];

        foreach ($activities as $activity) {
            $collectionId = $activity->collection_id;

            if (!array_key_exists($collectionId, $collectionsMap)) {
                $collection = $collectionsById[$collectionId];
                $collectionsMap[$collectionId] = new IndexEntryCollection(
                    $collection->name,
                    $collection->color
                );
            }

            $collectionsMap[$collectionId]->activities[] = new IndexEntryActivity(
                $activity->name,
                $activity->icon
            );
        }

        return array_values($collectionsMap);
    }


    public function collectMonthData(User $user): iterable {
        return $user->entries
            ->map(fn($entry) => ['date' => $entry->date->format("Y-m")])
            ->groupBy('date')
            ->map(fn ($group, $key) =>  new IndexMonth($group, new Carbon($key)))
            ->sortByDesc(['year', 'month'])
            ->values();
    }


    public function create(array $data, int $userId): Entry
    {
        $entry = new Entry($data);
        $entry->user()
            ->associate($userId)
            ->save();

        return $entry;
    }


    public function update(Entry $entry, array $data): Entry
    {
        $entry->fill($data);
        $entry->save();

        return $entry;
    }


    public function saveActivities(Entry $entry, array $activityIds): void
    {
        DB::table("activity_entry")
            ->where('entry_id', $entry->id)
            ->whereNotIn('activity_id', $activityIds)
            ->delete();
        $entry->activities()->sync($activityIds);
    }


    public function existsForDate(string $date, int $userId): bool
    {
        return Entry::query()
                ->where('user_id', $userId)
                ->where('date', $date)
                ->count() > 0;
    }


    public function savePhotos(Entry $entry, array $photoNames): void
    {
        $unusedPhotos = $entry->photos()->whereNotIn('name', $photoNames)->pluck('name');
        $entry->photos()->whereIn('name', $unusedPhotos)->delete();

        foreach ($unusedPhotos as $photo) {
            Storage::delete("photos/$photo");
        }

        $data = collect($photoNames)->map(fn($photo) => [
            'name' => $photo,
            'entry_id' => $entry->id,
        ])->toArray();
        DB::table('photos')->upsert($data, 'name', ['entry_id']);
    }
}
