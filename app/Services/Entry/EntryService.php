<?php

namespace App\Services\Entry;

use App\Models\Entry;
use App\Models\Support\IndexEntry;
use App\Models\Support\IndexMonth;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EntryService implements EntryServiceInterface
{
    /** @inheritDoc */
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


        /** @var User $user */
        $user = Auth::user();
        $goalsTotal = $user->goals->count();

        return $user
            ->entries()
            ->with(['activities', 'photos'])
            ->where('date', '>=', $startDate)
            ->where('date', '<=', $endDate)
            ->orderByDesc('date')
            ->get()
            ->map(fn(Entry $entry) => new IndexEntry(
                $entry->id,
                $entry->mood,
                $entry->weather,
                $goalsTotal,
                $entry->goals->count(),
                $entry->date,
                $entry->diary,
                $entry->photos->map(fn($photo) => $photo->name)->toArray(),
            ))
            ->toArray();
    }


    /** @inheritDoc */
    public function collectMonthData(User $user): iterable
    {
        return $user->entries
            ->map(fn($entry) => ['date' => $entry->date->format("Y-m")])
            ->groupBy('date')
            ->map(fn($group, $key) => new IndexMonth($group, new Carbon($key)))
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


    public function save(array $data): Entry
    {
        $entry = Entry::find($data['id']) ?? new Entry();
        $entry->fill($data);

        if ($entry->user_id == 0) {
            $entry->user_id = Auth::user()->id;
        }

        $entry->save();

        return $entry;
    }


    /** @inheritDoc */
    public function saveActivities(Entry $entry, array $activitiesIds): void
    {
        $entry->activities()->sync($activitiesIds);
    }



    /** @inheritDoc */
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


    /** @inheritDoc */
    public function saveGoals(Entry $entry, array $goalsIds): void
    {
        $entry->goals()->sync($goalsIds);
    }
}
