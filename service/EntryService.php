<?php

namespace service;

use App\Models\Activity;
use App\Models\Collection;
use App\Models\Support\IndexEntry;
use App\Models\Support\IndexEntryCollection;
use App\Models\Support\IndexEntryActivity;
use Illuminate\Support\Facades\Auth;

class EntryService implements EntryServiceInterface
{
    public function collectForIndex(int $month, int $year = null): array
    {
        $year = $year ?? date('Y');
        $startDate = date("$year-$month-01");
        $month++;
        $endDate = date("$year-$month-01");
        $user = Auth::user();
        $collectionsById = $user->collections->keyBy('id');

        return $user
            ->entries()
            ->with('activities')
            ->where('date', '>=', $startDate)
            ->where('date', '<', $endDate)
            ->get()
            ->map(fn($entry) => new IndexEntry(
                $entry->id,
                $entry->mood,
                $entry->weather,
                $entry->date,
                $entry->diary,
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
}
