<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class EntryController extends Controller
{
    public function index(): Response
    {
        $entries = Entry::query()
            ->with(['activities'])
            ->get()
            ->map(function ($entry) {
                return [
                    'mood' => $entry->mood,
                    'weather' => $entry->weather,
                    'date' => $entry->date,
                    'diary' => $entry->diary,
                    'collections' => $this->groupByCollection($entry->activities),
                ];
            })
            ->toArray();

        return Inertia::render('Entry/Index', [
            'entries' => $entries,
        ]);
    }

    private function groupByCollection(iterable $activities): array
    {
        $collections = [];
        foreach ($activities as $activity) {
            if (!array_key_exists($activity->collection_id, $collections)) {
                $collections[$activity->collection_id] = [
                    'name' => $activity->collection->name,
                    'color' => $activity->collection->color,
                    'activities' => []
                ];
            }

            $collections[$activity->collection_id]['activities'][] = $activity->makeHidden('collection')->toArray();
        }


        return array_values($collections);
    }
}
